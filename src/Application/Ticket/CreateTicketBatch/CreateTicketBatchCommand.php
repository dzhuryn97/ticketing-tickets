<?php

namespace App\Application\Ticket\CreateTicketBatch;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CreateTicketBatchCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $orderId
    )
    {
    }
}