<?php

namespace App\Domain\Order;

use Ramsey\Uuid\UuidInterface;

interface OrderRepositoryInterface
{
    /**
     * @return array<Order>
     */
    public function getAll():array;
    public function findById(UuidInterface $orderId):?Order;
    public function add(Order $order): void;

}