<?php

namespace App\Domain\Order\Exception;

use Ramsey\Uuid\UuidInterface;

class OrderNotFoundException extends \DomainException
{
    public function __construct(UuidInterface $orderId)
    {
        parent::__construct(sprintf('The order with the identifier %s was not found', $orderId));
    }
}
