<?php

namespace App\Application\Ticket\ArchiveTicketsForEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Ticket\TicketRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;
use Ticketing\Common\Infrastructure\Flusher;

class ArchiveTicketsForEventCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly TicketRepositoryInterface $ticketRepository,
        private readonly FlusherInterface $flusher
    )
    {
    }

    public function __invoke(ArchiveTicketsForEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if(!$event){
            throw new EventNotFoundException($command->eventId);
        }

        $tickets = $this->ticketRepository->getForEvent($event);

        foreach ($tickets as $ticket) {
            $ticket->archive();
        }

        $event->ticketsArchived();

        $this->flusher->flush();;
    }
}