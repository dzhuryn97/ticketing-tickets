<?php

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class TicketTypeSoldOutDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $ticketTypeId
    )
    {
        parent::__construct();
    }
}