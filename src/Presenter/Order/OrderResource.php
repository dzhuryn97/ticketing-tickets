<?php

namespace App\Presenter\Order;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Domain\Order\Order;
use App\Domain\Order\OrderItem;
use App\Domain\Order\OrderStatus;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            denormalizationContext: [
                'groups' => [
                    'order:create'
                ]
            ],
            processor: CreateOrderProcessor::class
        )
    ],
    shortName: 'Order',
    provider: OrderStateProvider::class
)]
class OrderResource
{
    public function __construct(
        public ?UuidInterface      $id = null,
        /**
         * @var array<OrderItemResource>
         */
        public ?array              $orderItems = [],
        public ?UuidInterface      $customerId = null,
        public ?OrderStatus        $orderStatus = null,
        public ?float              $totalPrice = null,
        public ?string             $currency = null,
        public ?bool               $ticketIssued = null,
        public ?\DateTimeImmutable $createdAt = null
    )
    {
    }

    public static function createFromOrder(Order $order): self
    {
        $orderItemResources = array_map(function (OrderItem $orderItem) {
            return OrderItemResource::fromOrderItem($orderItem);
        }, $order->getOrderItems());
        return new self(
            $order->getId(),
            $orderItemResources,
            $order->getCustomer()->getId(),
            $order->getStatus(),
            $order->getTotalPrice(),
            $order->getCurrency(),
            $order->isTicketIssued(),
            $order->getCreatedAt()
        );
    }
}
