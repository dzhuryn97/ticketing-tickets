<?php

namespace App\Presenter\Cart;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\Cart\GetCart\GetCartQuery;
use Ticketing\Common\Application\Query\QueryBusInterface;
use Ticketing\Common\Application\Security\Security;

class CartProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly Security $security,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $customer = $this->security->connectedUser();

        $cart = $this->queryBus->ask(
            new GetCartQuery(
                $customer->id,
            )
        );

        $cartResource = CartResource::fromCart($cart);

        if ($operation instanceof GetCollection) {
            return [$cartResource];
        }

        return $cartResource;
    }
}
