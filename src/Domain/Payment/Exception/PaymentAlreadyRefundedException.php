<?php

namespace App\Domain\Payment\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class PaymentAlreadyRefundedException extends BusinessException
{
    public function __construct()
    {
        parent::__construct(
            'The payment was already refunded',
            'PaymentAlreadyRefunded'
        );
    }
}
