<?php

namespace App\Domain\Event\Exception;

class TicketTypeNotEnoughQuantity extends \DomainException
{
    public function __construct(int $availableQuantity)
    {
        parent::__construct(
            sprintf('The ticket type has %s quantity available', $availableQuantity)
        );
    }
}
