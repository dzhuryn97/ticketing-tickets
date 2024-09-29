<?php

namespace App\Domain\Event\Exception;

use App\Domain\Event\TicketType;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class TicketTypeNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $ticketTypeId)
    {
        parent::__construct($ticketTypeId, TicketType::class);
    }
}
