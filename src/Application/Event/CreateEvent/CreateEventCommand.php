<?php

namespace App\Application\Event\CreateEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CreateEventCommand implements CommandInterface
{
    /**
     * @param array<TicketTypeRequest> $ticketTypes
     */
    public function __construct(
        public readonly UuidInterface $eventId,
        public readonly string $title,
        public readonly string $description,
        public readonly string $location,
        public readonly \DateTimeImmutable $startsAt,
        public readonly ?\DateTimeImmutable $endsAt,
        public readonly array $ticketTypes,
    ) {
    }
}
