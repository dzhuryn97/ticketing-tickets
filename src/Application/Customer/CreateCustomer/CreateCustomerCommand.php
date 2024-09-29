<?php

namespace App\Application\Customer\CreateCustomer;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $customerId,
        public readonly string $name,
        public readonly string $email,
    ) {
    }
}
