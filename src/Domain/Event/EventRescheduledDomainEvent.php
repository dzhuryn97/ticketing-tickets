<?php

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class EventRescheduledDomainEvent extends DomainEvent
{

    public function __construct(
        public readonly UuidInterface $eventId,
        public readonly \DateTimeImmutable  $startsAt,
        public readonly ?\DateTimeImmutable $endsAt,
    )
    {
        parent::__construct();
    }
}