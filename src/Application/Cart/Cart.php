<?php

namespace App\Application\Cart;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Cart
{
    public UuidInterface $customerId;

    /**
     * @var Collection<CartItem>
     */
    public Collection $items;

    public function __construct(
        UuidInterface $customerId,
        array $items = [],
    ) {
        $this->customerId = $customerId;
        $this->items = new ArrayCollection($items);
    }
}
