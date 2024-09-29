<?php

namespace App\Domain\Payment\Exception;

class PaymentNotEnoughFundsException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('There are not enough funds for a refund');
    }
}
