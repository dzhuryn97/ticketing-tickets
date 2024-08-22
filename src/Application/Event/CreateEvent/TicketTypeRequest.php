<?php

namespace App\Application\Event\CreateEvent;

use Ramsey\Uuid\UuidInterface;

class TicketTypeRequest
{
    public function __construct(
        public readonly UuidInterface $ticketTypeId,
        public readonly UuidInterface $eventId,
        public readonly string $name,
        public readonly float $price,
        public readonly string $currency,
        public readonly int $quantity,
    )
    {
    }
}