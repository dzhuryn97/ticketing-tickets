<?php

namespace App\Presenter\Cart\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Cart\ClearCart\ClearCartCommand;
use App\Application\Cart\GetCart\GetCartQuery;
use App\Presenter\Cart\CartResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;
use Ticketing\Common\Application\Security\Security;

class ClearCartProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly Security $security
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $customer = $this->security->connectedUser();

        $this->commandBus->dispatch(
            new ClearCartCommand(
                $customer->id,
            )
        );

        $customer = $this->security->connectedUser();

        $cart = $this->queryBus->ask(
            new GetCartQuery(
                $customer->id,
            )
        );

        $cartResource = CartResource::fromCart($cart);


        return $cartResource;

    }
}