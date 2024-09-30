<?php

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;

interface TicketTypeRepositoryInterface
{
    public function findById(UuidInterface $ticketTypeId): ?TicketType;

    public function findWithLock(UuidInterface $ticketTypeId): ?TicketType;

    /**
     * @param array<TicketType> $ticketTypes
     */
    public function addBatch(array $ticketTypes): void;

    public function save(TicketType $ticketType): void;
}
