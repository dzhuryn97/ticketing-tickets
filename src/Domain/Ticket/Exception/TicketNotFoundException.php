<?php

namespace App\Domain\Ticket\Exception;

use App\Domain\Ticket\Ticket;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class TicketNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $ticketId)
    {
        parent::__construct($ticketId, Ticket::class);
    }
}
