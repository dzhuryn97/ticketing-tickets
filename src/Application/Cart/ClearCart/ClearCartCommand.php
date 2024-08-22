<?php

namespace App\Application\Cart\ClearCart;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class ClearCartCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $customerId
    )
    {
    }
}