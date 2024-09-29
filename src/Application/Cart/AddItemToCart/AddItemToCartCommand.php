<?php

namespace App\Application\Cart\AddItemToCart;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class AddItemToCartCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $customerId,
        public readonly UuidInterface $ticketTypeId,
        public readonly int $quantity,
    ) {
    }
}
