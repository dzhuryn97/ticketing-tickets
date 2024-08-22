<?php

namespace App\Domain\Customer;

use Ramsey\Uuid\UuidInterface;

interface CustomerRepositoryInterface
{
    public function add(Customer $customer): void;
    public function findById(UuidInterface $customerId): ?Customer;
}