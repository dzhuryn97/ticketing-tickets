<?php

namespace App\Application\Cart;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Caching\CacheInterface;

class CartService
{
    private CacheInterface $cache;

    public function __construct(
        CacheInterface $cache,
    ) {
        $this->cache = $cache;
    }

    public function getCart(UuidInterface $customerId): Cart
    {
        $key = $this->generateCacheKey($customerId);

        return $this->cache->find($key) ?? $this->createDefault($customerId);
    }

    public function addItem(UuidInterface $customerId, CartItem $cartItem): void
    {
        $cacheKey = $this->generateCacheKey($customerId);
        $cart = $this->getCart($customerId);

        /** @var ?CartItem $existingCartItem */
        $existingCartItem = $cart->items->filter(function (CartItem $c) use ($cartItem) {
            return $c->ticketTypeId->equals($cartItem->ticketTypeId);
        })->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $cartItem->quantity;
        } else {
            $cart->items->add($cartItem);
        }

        $this->cache->set($cacheKey, $cart);
    }

    public function removeItem(UuidInterface $customerId, UuidInterface $ticketTypeId): void
    {
        $cacheKey = $this->generateCacheKey($customerId);
        $cart = $this->getCart($customerId);

        /** @var ?CartItem $existingCartItem */
        $cartItem = $cart->items->filter(function (CartItem $c) use ($ticketTypeId) {
            return $c->ticketTypeId->equals($ticketTypeId);
        })->first();

        if (!$cartItem) {
            return;
        }

        $cart->items->removeElement($cartItem);
        $this->cache->set($cacheKey, $cart);
    }

    public function clear(UuidInterface $customerId): void
    {
        $cacheKey = sprintf('cart-%s', $customerId);
        $cart = $this->createDefault($customerId);
        $this->cache->set($cacheKey, $cart);
    }

    private function generateCacheKey(UuidInterface $customerId)
    {
        return sprintf('cart-%s', $customerId);
    }

    private function createDefault(UuidInterface $customerId): Cart
    {
        return new Cart($customerId);
    }
}
