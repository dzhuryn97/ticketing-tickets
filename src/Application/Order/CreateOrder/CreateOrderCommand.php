<?php

namespace App\Application\Order\CreateOrder;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CreateOrderCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $customerId
    )
    {
    }
}