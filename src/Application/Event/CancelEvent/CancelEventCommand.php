<?php

namespace App\Application\Event\CancelEvent;

use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Application\Command\CommandInterface;

class CancelEventCommand implements CommandInterface
{
    public function __construct(
        public readonly UuidInterface $eventId,
    ) {
    }
}
