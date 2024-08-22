<?php

namespace App\Domain\Customer\Exception;

use Ramsey\Uuid\UuidInterface;

class CustomerNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $customerId)
    {
        parent::__construct(sprintf('Customer with identifier %s not found', $customerId));
    }
}