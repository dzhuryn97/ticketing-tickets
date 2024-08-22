<?php

namespace App\Application\Customer\UpdateCustomer;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class UpdateCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $customerId,
        public readonly string $name,
        public readonly string $email,
    )
    {
    }
}