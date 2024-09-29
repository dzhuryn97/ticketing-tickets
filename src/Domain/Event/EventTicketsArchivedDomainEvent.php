<?php

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class EventTicketsArchivedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $eventId,
    ) {
        parent::__construct();
    }
}
