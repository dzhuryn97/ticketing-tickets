<?php

namespace App\Application\Customer\GetCustomer;

use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use Ticketing\Common\Application\Query\QueryHandlerInterface;

class GetCustomerQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
    )
    {
    }

    public function __invoke(
        GetCustomerQuery $query
    )
    {
        $customer = $this->customerRepository->findById($query->customerId);
        if (!$customer) {
            throw new CustomerNotFoundException($query->customerId);
        }
        return $customer;
    }
}