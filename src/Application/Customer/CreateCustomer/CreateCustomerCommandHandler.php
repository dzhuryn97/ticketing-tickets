<?php

namespace App\Application\Customer\CreateCustomer;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function __invoke(CreateCustomerCommand $command)
    {
        $customer = new Customer(
            $command->customerId,
            $command->name,
            $command->email,
        );

        $this->customerRepository->add($customer);

        return $customer->getId();
    }
}
