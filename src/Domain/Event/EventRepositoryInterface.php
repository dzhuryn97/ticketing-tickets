<?php

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;

interface EventRepositoryInterface
{
    public function findById(UuidInterface $eventId): ?Event;

    public function add(Event $event): void;
}
