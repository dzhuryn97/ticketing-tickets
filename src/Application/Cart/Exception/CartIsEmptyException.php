<?php

namespace App\Application\Cart\Exception;

class CartIsEmptyException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The cart is empty');
    }
}
