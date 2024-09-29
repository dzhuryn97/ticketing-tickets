<?php

namespace App\Domain\Order;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class OrderTicketsIssuedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $orderId,
    ) {
        parent::__construct();
    }
}
