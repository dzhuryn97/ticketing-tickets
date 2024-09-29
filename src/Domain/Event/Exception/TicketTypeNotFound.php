<?php

namespace App\Domain\Event\Exception;

use Ramsey\Uuid\UuidInterface;

class TicketTypeNotFound extends \DomainException
{
    public function __construct(UuidInterface $ticketTypeId)
    {
        parent::__construct(sprintf('The ticket type with the identifier %s was not found', $ticketTypeId));
    }
}
