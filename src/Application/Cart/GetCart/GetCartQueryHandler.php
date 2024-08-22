<?php

namespace App\Application\Cart\GetCart;

use App\Application\Cart\CartService;
use App\Application\Cart\ClearCart\ClearCartCommand;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use App\Domain\Event\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetCartQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly CartService $cartService
    )
    {
    }

    public function __invoke(GetCartQuery $command)
    {
        $customer = $this->customerRepository->findById($command->customerId);
        if(!$customer){
            throw new CustomerNotFoundException($command->customerId);
        }

        return $this->cartService->getCart($customer->getId());
    }
}