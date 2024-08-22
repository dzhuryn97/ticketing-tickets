<?php

namespace App\Application\Cart\RemoveItemFromCart;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class RemoveItemFromCartCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $customerId,
        public readonly UuidInterface $ticketTypeId
    )
    {
    }
}