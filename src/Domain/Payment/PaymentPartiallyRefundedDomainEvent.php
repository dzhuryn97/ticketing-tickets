<?php

namespace App\Domain\Payment;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class PaymentPartiallyRefundedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $paymentId,
        public readonly UuidInterface $transactionId,
        public readonly float         $refundAmount

    )
    {
        parent::__construct();
    }
}