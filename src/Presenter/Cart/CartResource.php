<?php

namespace App\Presenter\Cart;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Application\Cart\Cart;
use App\Application\Cart\CartItem;
use App\Presenter\Cart\Processor\AddItemToCartProcessor;
use App\Presenter\Cart\Processor\ClearCartProcessor;
use App\Presenter\Cart\Processor\RemoveItemFromCartProcessor;
use Ramsey\Uuid\UuidInterface;

#[ApiResource(
    shortName: 'Cart',
    operations: [
        new Get(),
        new Post(
            openapiContext: [
                'summary' => 'Add item to cart',
            ],
            denormalizationContext: [
                'groups' => ['cart-item:add'],
            ],
            input: CartItemResource::class,
            processor: AddItemToCartProcessor::class,
        ),

        new Delete(
            uriTemplate: 'carts/{ticketTypeId}',
            openapiContext: [
                'summary' => 'Remove item from cart',
            ],
            denormalizationContext: [
                'groups' => ['cart-item:remove'],
            ],
            read: true,
            processor: RemoveItemFromCartProcessor::class,
        ),
        new Delete(
            read: true,
            processor: ClearCartProcessor::class,
        ),
    ],
    security: "is_granted('ROLE_USER')",
    provider: CartProvider::class
)]
class CartResource
{
    public ?UuidInterface $customerId;

    /**
     * @var array<CartItemResource>
     */
    public ?array $items;

    public function __construct(
        ?UuidInterface $customerId,
        ?array $items,
    ) {
        $this->customerId = $customerId;
        $this->items = $items;
    }

    public static function fromCart(Cart $cart): self
    {
        return new self(
            $cart->customerId,
            $cart->items->map(function (CartItem $cartItem) {
                return CartItemResource::fromCartItem($cartItem);
            })->toArray()
        );
    }
}
