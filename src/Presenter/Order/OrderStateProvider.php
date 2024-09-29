<?php

namespace App\Presenter\Order;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Order\GetOrder\GetOrderQuery;
use App\Application\Order\GetOrder\GetOrdersQuery;
use App\Domain\Order\Order;
use Ticketing\Common\Application\Query\QueryBusInterface;

class OrderStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof Get) {
            $order = $this->queryBus->ask(new GetOrderQuery($uriVariables['id']));

            return OrderResource::createFromOrder($order);
        }
        $orders = $this->queryBus->ask(new GetOrdersQuery());

        return array_map(function (Order $order) {
            return OrderResource::createFromOrder($order);
        }, $orders);
    }
}
