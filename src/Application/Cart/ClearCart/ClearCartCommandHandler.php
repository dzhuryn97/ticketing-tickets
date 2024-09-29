<?php

namespace App\Application\Cart\ClearCart;

use App\Application\Cart\CartService;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class ClearCartCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly CartService $cartService,
    ) {
    }

    public function __invoke(ClearCartCommand $command)
    {
        $customer = $this->customerRepository->findById($command->customerId);
        if (!$customer) {
            throw new CustomerNotFoundException($command->customerId);
        }

        $this->cartService->clear($customer->getId());
    }
}
