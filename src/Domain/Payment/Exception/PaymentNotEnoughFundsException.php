<?php

namespace App\Domain\Payment\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class PaymentNotEnoughFundsException extends BusinessException
{
    public function __construct()
    {
        parent::__construct(
            'There are not enough funds for a refund',
            'PaymentNotEnoughFunds'
        );
    }
}
