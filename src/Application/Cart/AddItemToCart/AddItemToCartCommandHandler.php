<?php

namespace App\Application\Cart\AddItemToCart;

use App\Application\Cart\CartItem;
use App\Application\Cart\CartService;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use App\Domain\Event\Exception\TicketTypeNotFound;
use App\Domain\Event\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class AddItemToCartCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
        private readonly CartService $cartService,
    ) {
    }

    public function __invoke(AddItemToCartCommand $command)
    {
        $customer = $this->customerRepository->findById($command->customerId);
        if (!$customer) {
            throw new CustomerNotFoundException($command->customerId);
        }
        $ticketType = $this->ticketTypeRepository->findById($command->ticketTypeId);
        if (!$ticketType) {
            throw new TicketTypeNotFound($command->ticketTypeId);
        }

        $cartItem = new CartItem(
            $ticketType->getId(),
            $command->quantity,
            $ticketType->getPrice(),
            $ticketType->getCurrency()
        );
        $this->cartService->addItem($customer->getId(), $cartItem);
    }
}
