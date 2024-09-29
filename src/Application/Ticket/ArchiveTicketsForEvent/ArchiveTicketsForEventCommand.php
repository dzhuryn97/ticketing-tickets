<?php

namespace App\Application\Ticket\ArchiveTicketsForEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class ArchiveTicketsForEventCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $eventId,
    ) {
    }
}
