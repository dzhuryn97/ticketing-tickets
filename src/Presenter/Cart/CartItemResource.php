<?php

namespace App\Presenter\Cart;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class CartItemResource
{

    #[Groups(['cart-item:add','cart-item:remove'])]
    public ?UuidInterface $ticketTypeId;
    public ?int $price;
    #[Groups(['cart-item:add'])]
    public ?int $quantity;
    public ?string $currency;

    public function __construct(
        ?UuidInterface $ticketTypeId,
        ?int           $price,
        ?int           $quantity,
        ?string        $currency,
    )
    {
        $this->ticketTypeId = $ticketTypeId;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->currency = $currency;
    }

    public static function fromCartItem(\App\Application\Cart\CartItem $cartItem): self
    {
        return new self(
            $cartItem->ticketTypeId,
            $cartItem->price,
            $cartItem->quantity,
            $cartItem->currency,
        );
    }
}