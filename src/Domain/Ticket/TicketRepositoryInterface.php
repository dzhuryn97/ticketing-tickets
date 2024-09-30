<?php

namespace App\Domain\Ticket;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;

interface TicketRepositoryInterface
{
    public function findById(UuidInterface $ticketId): ?Ticket;

    /**
     * @return array<Ticket>
     */
    public function getForEvent(Event $event): array;

    /**
     * @param array<Ticket> $tickets
     */
    public function addBatch(array $tickets): void;

    public function save(Ticket $ticket): void;
}
