<?php

namespace App\Domain\Event\Exception;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\Exception\EntityNotFoundException;

class EventNotFoundException extends EntityNotFoundException
{
    public function __construct(UuidInterface $eventId)
    {
        parent::__construct($eventId, Event::class);
    }
}
