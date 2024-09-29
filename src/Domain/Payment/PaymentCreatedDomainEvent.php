<?php

namespace App\Domain\Payment;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEvent;

class PaymentCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidInterface $paymentId,
    ) {
        parent::__construct();
    }
}
