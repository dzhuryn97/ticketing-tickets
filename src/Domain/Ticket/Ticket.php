<?php

namespace App\Domain\Ticket;

use App\Domain\Customer\Customer;
use App\Domain\Event\Event;
use App\Domain\Event\TicketType;
use App\Domain\Order\Order;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(
    repositoryClass: TicketRepositoryInterface::class
)]
#[ORM\Table('`ticket')]
class Ticket extends DomainEntity
{
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getTicketType(): TicketType
    {
        return $this->ticketType;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    private Customer $customer;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    private Order $order;

    #[ORM\ManyToOne(targetEntity: Event::class)]
    private Event $event;

    #[ORM\ManyToOne(targetEntity: TicketType::class)]
    private TicketType $ticketType;

    #[ORM\Column]
    private string $code;
    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "boolean")]
    private bool $archived = false;

    public function __construct(Order $order, TicketType $ticketType)
    {
        $this->id = Uuid::uuid4();
        $this->customer = $order->getCustomer();
        $this->order = $order;
        $this->event = $ticketType->getEvent();
        $this->ticketType = $ticketType;
        $this->code = 'tc_' . Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable();

        $this->raiseDomainEvent(new TicketCreatedDomainEvent($this->id));

    }


    public function archive(): void
    {
        if ($this->archived) {
            return;
        }

        $this->archived = true;

        $this->raiseDomainEvent(new TicketArchivedDomainEvent($this->id, $this->code));
    }
}