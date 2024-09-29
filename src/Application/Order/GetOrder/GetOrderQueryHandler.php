<?php

namespace App\Application\Order\GetOrder;

use App\Domain\Order\Exception\OrderNotFoundException;
use App\Domain\Order\OrderRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
    ) {
    }

    public function __invoke(GetOrderQuery $query)
    {
        $order = $this->orderRepository->findById($query->orderId);
        if (!$order) {
            throw new OrderNotFoundException($query->orderId);
        }

        return $order;
    }
}
