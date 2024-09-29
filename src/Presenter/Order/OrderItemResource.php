<?php

namespace App\Presenter\Order;

use Ramsey\Uuid\UuidInterface;

class OrderItemResource
{
    public function __construct(
        public ?UuidInterface $id,
        public ?UuidInterface $ticketTypeId,
        public ?int $quantity,
        public ?float $price,
        public ?float $totalPrice,
        public ?string $currency,
    ) {
    }

    public static function fromOrderItem(\App\Domain\Order\OrderItem $orderItem): self
    {
        return new self(
            $orderItem->getId(),
            $orderItem->getTicketType()->getId(),
            $orderItem->getQuantity(),
            $orderItem->getPrice(),
            $orderItem->getTotalPrice(),
            $orderItem->getCurrency()
        );
    }
}
