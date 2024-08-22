<?php

namespace App\Application\Customer\GetCustomer;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Query\QueryInterface;

class GetCustomerQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $customerId
    )
    {
    }
}