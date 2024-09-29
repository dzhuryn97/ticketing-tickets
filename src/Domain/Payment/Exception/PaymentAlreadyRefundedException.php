<?php

namespace App\Domain\Payment\Exception;

class PaymentAlreadyRefundedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The payment was already refunded');
    }
}
