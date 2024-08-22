<?php

namespace App\Presenter\Cart\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Cart\GetCart\GetCartQuery;
use App\Application\Cart\RemoveItemFromCart\RemoveItemFromCartCommand;
use App\Presenter\Cart\CartResource;
use Ramsey\Uuid\Uuid;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;
use Ticketing\Common\Application\Security\Security;

class RemoveItemFromCartProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly Security            $security
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $customer = $this->security->connectedUser();

        $ticketTypeId = Uuid::fromString($uriVariables['ticketTypeId']);

        $this->commandBus->dispatch(
            new RemoveItemFromCartCommand(
                $customer->id,
                $ticketTypeId,
            )
        );

        $cart = $this->queryBus->ask(
            new GetCartQuery(
                $customer->id
            )
        );
        return CartResource::fromCart($cart);
    }
}