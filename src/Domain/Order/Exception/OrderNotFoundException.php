<?php

namespace App\Domain\Order\Exception;

use App\Domain\Order\Order;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class OrderNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $orderId)
    {
        parent::__construct($orderId, Order::class);
    }
}
