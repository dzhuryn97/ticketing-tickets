<?php

namespace App\Domain\Payment\Exception;

use Ramsey\Uuid\UuidInterface;

class PaymentNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $paymentId)
    {
        parent::__construct(sprintf('The payment with the identifier %s was not found', $paymentId));
    }
}