<?php

namespace App\Domain\Event;

use App\Domain\Event\Exception\TicketTypeNotEnoughQuantityException;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[ORM\Entity(
    repositoryClass: TicketTypeRepositoryInterface::class
)]
class TicketType extends DomainEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;
    #[ORM\ManyToOne(targetEntity: Event::class)]
    private Event $event;
    #[ORM\Column]
    private string $name;
    #[ORM\Column]
    private float $price;
    #[ORM\Column]
    private string $currency;
    #[ORM\Column]
    private int $quantity;
    #[ORM\Column]
    private int $availableQuantity;

    public function __construct(
        UuidInterface $id,
        Event $event,
        string $name,
        float $price,
        string $currency,
        int $quantity,
    ) {
        $this->id = $id;
        $this->event = $event;
        $this->name = $name;
        $this->price = $price;
        $this->currency = $currency;
        $this->quantity = $quantity;
        $this->availableQuantity = $quantity;
    }

    public function updatePrice(float $price): void
    {
        $this->price = $price;
    }

    public function updateQuantity(int $quantity): void
    {
        if ($this->availableQuantity < $quantity) {
            throw new TicketTypeNotEnoughQuantityException($this->availableQuantity);
        }

        $this->availableQuantity -= $quantity;

        if (0 == $this->availableQuantity) {
            $this->raiseDomainEvent(new TicketTypeSoldOutDomainEvent($this->id));
        }
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getAvailableQuantity(): int
    {
        return $this->availableQuantity;
    }
}
