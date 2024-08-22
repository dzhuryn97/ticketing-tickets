<?php

namespace App\Domain\Ticket\Exception;

use Ramsey\Uuid\UuidInterface;

class TicketNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $ticketId)
    {
        parent::__construct(sprintf('Ticket with identifier %s not found', $ticketId));
    }
}