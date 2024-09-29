<?php

namespace App\Domain\Order\Exception;

use Ticketing\Common\Domain\Exception\BusinessException;

class TicketsAlreadyIssuedException extends BusinessException
{
    public function __construct()
    {
        parent::__construct(
            'The tickets for this order were already issued',
            'TicketsAlreadyIssued'
        );
    }
}
