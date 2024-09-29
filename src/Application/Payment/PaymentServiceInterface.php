<?php

namespace App\Application\Payment;

use Ramsey\Uuid\UuidInterface;

interface PaymentServiceInterface
{
    public function charge(float $amount, string $currency): PaymentResponse;

    public function refund(UuidInterface $transactionId, float $amount);
}
