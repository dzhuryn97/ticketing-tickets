<?php

namespace App\Domain\Order;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class OrderCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $orderId
    )
    {
        parent::__construct();
    }
}