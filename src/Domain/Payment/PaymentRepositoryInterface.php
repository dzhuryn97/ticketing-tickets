<?php

namespace App\Domain\Payment;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;

interface PaymentRepositoryInterface
{
    public function findById(UuidInterface $paymentId):?Payment;

    /**
     * @return array<Payment>
     */
    public function getForEvent(Event $event): array;

    public function add(Payment $payment):void;
}