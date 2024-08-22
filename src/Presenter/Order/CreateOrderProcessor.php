<?php

namespace App\Presenter\Order;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Order\CreateOrder\CreateOrderCommand;
use App\Application\Order\GetOrder\GetOrderQuery;
use App\Application\Order\GetOrder\GetOrdersQuery;
use App\Domain\Order\Order;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;
use Ticketing\Common\Application\Security\Security;

class CreateOrderProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly Security $security
    )
    {
    }

    /**
     * @param OrderResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
            $customer = $this->security->connectedUser();

            $orderId = $this->commandBus->dispatch(new CreateOrderCommand(
                $customer->id
            ));

            $order = $this->queryBus->ask(new GetOrderQuery($orderId));
            return OrderResource::createFromOrder($order);


    }
}