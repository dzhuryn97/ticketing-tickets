<?php

namespace App\Domain\Payment\Exception;

use App\Domain\Payment\Payment;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class PaymentNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $paymentId)
    {
        parent::__construct($paymentId, Payment::class);
    }
}
