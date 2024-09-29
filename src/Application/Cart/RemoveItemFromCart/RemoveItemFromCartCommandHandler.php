<?php

namespace App\Application\Cart\RemoveItemFromCart;

use App\Application\Cart\CartService;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use App\Domain\Event\Exception\TicketTypeNotFound;
use App\Domain\Event\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class RemoveItemFromCartCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
        private readonly CartService $cartService,
    ) {
    }

    public function __invoke(RemoveItemFromCartCommand $command)
    {
        $customer = $this->customerRepository->findById($command->customerId);
        if (!$customer) {
            throw new CustomerNotFoundException($command->customerId);
        }
        $ticketType = $this->ticketTypeRepository->findById($command->ticketTypeId);
        if (!$ticketType) {
            throw new TicketTypeNotFound($command->ticketTypeId);
        }

        $this->cartService->removeItem($customer->getId(), $ticketType->getId());
    }
}
