<?php

namespace App\Infrastructure\Payment;

use App\Application\Payment\PaymentResponse;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PaymentServiceFakeImpl implements \App\Application\Payment\PaymentServiceInterface
{

    public function charge(float $amount, string $currency): PaymentResponse
    {

        return new PaymentResponse(
            Uuid::uuid4(),
            $amount,
            $currency
        );
    }

    public function refund(UuidInterface $transactionId, float $amount)
    {
    }
}