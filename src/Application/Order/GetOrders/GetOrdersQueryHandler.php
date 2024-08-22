<?php

namespace App\Application\Order\GetOrders;

use App\Application\Order\GetOrder\GetOrdersQuery;
use App\Domain\Order\OrderRepositoryInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetOrdersQueryHandler implements QueryHandlerInterface
{

    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    )
    {
    }

    public function __invoke(GetOrdersQuery $query)
    {
        $orders = $this->orderRepository->getAll();

        return $orders;
    }
}