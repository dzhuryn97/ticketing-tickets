<?php

namespace App\Application\Cart;

use Ramsey\Uuid\UuidInterface;

class CartItem
{
    public function __construct(
        public UuidInterface $ticketTypeId,
        public int           $quantity,
        public int           $price,
        public string           $currency,
    )
    {
    }


}