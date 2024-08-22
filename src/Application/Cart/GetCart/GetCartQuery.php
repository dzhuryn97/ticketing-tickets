<?php

namespace App\Application\Cart\GetCart;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;
use Ticketing\Common\Application\Query\QueryInterface;

class GetCartQuery implements QueryInterface
{
    public function __construct(
        public readonly UuidInterface $customerId
    )
    {
    }
}