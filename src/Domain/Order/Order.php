<?php

namespace App\Domain\Order;

use App\Domain\Customer\Customer;
use App\Domain\Event\TicketType;
use App\Domain\Order\Exception\TicketsAlreadyIssuedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[ORM\Entity(
    repositoryClass: OrderRepositoryInterface::class,
)]
#[ORM\Table('`order`')]
class Order extends DomainEntity
{
    #[ORM\Id()]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order', cascade: ['persist'])]
    private Collection $orderItems;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    private Customer $customer;

    #[ORM\Column]
    private OrderStatus $status;

    #[ORM\Column]
    private float $totalPrice;
    #[ORM\Column]
    private string $currency;
    #[ORM\Column]
    private bool $ticketIssued;
    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct(Customer $customer)
    {
        $this->id = Uuid::uuid4();
        $this->customer = $customer;
        $this->status = OrderStatus::Pending;
        $this->createdAt = new \DateTimeImmutable();
        $this->orderItems = new ArrayCollection();
        $this->ticketIssued = false;

        $this->raiseDomainEvent(new OrderCreatedDomainEvent($this->id));
    }

    public function addItem(
        TicketType $ticketType,
        int $quantity,
        float $price,
        string $currency,
    ): void {
        $orderItem = new OrderItem(
            $ticketType,
            $quantity,
            $price,
            $currency
        );

        $orderItem->setOrder($this);
        $this->orderItems->add($orderItem);

        $this->totalPrice = array_sum($this->orderItems->map(function (OrderItem $orderItem) {
            return $orderItem->getTotalPrice();
        })->toArray());
        $this->currency = $currency;
    }

    public function issueTickets(): void
    {
        if ($this->ticketIssued) {
            throw new TicketsAlreadyIssuedException();
        }

        $this->ticketIssued = true;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return array<OrderItem>
     */
    public function getOrderItems(): array
    {
        return $this->orderItems->getValues();
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isTicketIssued(): bool
    {
        return $this->ticketIssued;
    }
}
