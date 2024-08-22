<?php

namespace App\Domain\Order;

use App\Domain\Event\TicketType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class OrderItem
{
    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: TicketType::class)]
    private TicketType $ticketType;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderItems')]
    private Order $order;

    #[ORM\Column]
    private int $quantity;
    #[ORM\Column]
    private float $price;

    #[ORM\Column]
    private float $totalPrice;

    #[ORM\Column]
    private string $currency;


    public function __construct(
        TicketType $ticketType,
        Order $order,
        int $quantity,
        float $price,
        string $currency
    )
    {
        $this->id = Uuid::uuid4();
        $this->ticketType = $ticketType;
        $this->order = $order;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->totalPrice = $price * $quantity;
        $this->currency = $currency;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getTicketType(): TicketType
    {
        return $this->ticketType;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

}