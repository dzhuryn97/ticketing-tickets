<?php

namespace App\Application\Cart\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class CartIsEmptyException extends BusinessException
{
    public function __construct()
    {
        parent::__construct('The cart is empty', 'CartIsEmpty');
    }
}
