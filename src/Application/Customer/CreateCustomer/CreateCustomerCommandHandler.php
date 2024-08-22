<?php

namespace App\Application\Customer\CreateCustomer;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly FlusherInterface $flusher
    )
    {
    }

    public function __invoke(CreateCustomerCommand $command)
    {
        $customer = new Customer(
            $command->customerId,
            $command->name,
            $command->email,
        );

        $this->customerRepository->add($customer);
        $this->flusher->flush();

        return $customer->getId();
    }
}