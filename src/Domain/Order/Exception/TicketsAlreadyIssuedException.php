<?php

namespace App\Domain\Order\Exception;

class TicketsAlreadyIssuedException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('The tickets for this order were already issued');
    }
}