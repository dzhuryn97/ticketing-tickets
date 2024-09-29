<?php

namespace App\Application\Payment\RefundPaymentsForEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class RefundPaymentsForEventCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $eventId,
    ) {
    }
}
