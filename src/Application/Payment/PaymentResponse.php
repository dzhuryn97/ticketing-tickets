<?php

namespace App\Application\Payment;

use Ramsey\Uuid\UuidInterface;

class PaymentResponse
{
    public function __construct(
        public readonly UuidInterface $transactionId,
        public readonly float         $amount,
        public readonly string        $currency
    )
    {
    }
}