<?php

namespace App\Domain\Event\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class TicketTypeNotEnoughQuantityException extends BusinessException
{
    public function __construct(int $availableQuantity)
    {
        parent::__construct(
            sprintf('The ticket type has %s quantity available', $availableQuantity),
            'TicketTypeNotEnoughQuantity'
        );
    }
}
