<?php

namespace App\Domain\Customer\Exception;

use App\Domain\Customer\Customer;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class CustomerNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $customerId)
    {
        parent::__construct($customerId, Customer::class);
    }
}
