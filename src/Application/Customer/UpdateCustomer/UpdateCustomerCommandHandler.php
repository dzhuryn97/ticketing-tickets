<?php

namespace App\Application\Customer\UpdateCustomer;

use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class UpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly FlusherInterface $flusher
    )
    {
    }

    public function __invoke(UpdateCustomerCommand $command)
    {
        $customer = $this->customerRepository->findById($command->customerId);
        if(!$customer){
            throw new CustomerNotFoundException($command->customerId);
        }

        $customer->update(
            $command->name,
            $command->email,
        );
        $this->flusher->flush();

    }
}