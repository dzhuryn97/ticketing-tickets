<?php

namespace App\Application\Order\GetOrder;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

class GetOrderQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $orderId
    )
    {
    }
}