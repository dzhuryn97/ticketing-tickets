<?php

namespace App\Domain\Ticket;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class TicketArchivedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $ticketId,
        public readonly string $code,
    ) {
        parent::__construct();
    }
}
