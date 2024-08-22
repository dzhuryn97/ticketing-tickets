<?php

namespace App\Presenter\Cart\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Cart\AddItemToCart\AddItemToCartCommand;
use App\Application\Cart\GetCart\GetCartQuery;
use App\Presenter\Cart\CartItemResource;
use App\Presenter\Cart\CartResource;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\Query\QueryBusInterface;
use Ticketing\Common\Application\Security\Security;

class AddItemToCartProcessor implements ProcessorInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly Security $security
    )
    {
    }

    /**
     * @param CartItemResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $customer = $this->security->connectedUser();

        $this->commandBus->dispatch(
            new AddItemToCartCommand(
                $customer->id,
                $data->ticketTypeId,
                $data->quantity,
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