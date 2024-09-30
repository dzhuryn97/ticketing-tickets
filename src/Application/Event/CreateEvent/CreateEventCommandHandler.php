<?php

namespace App\Application\Event\CreateEvent;

use App\Domain\Event\Event;
use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\TicketType;
use App\Domain\Event\TicketTypeRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;

class CreateEventCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
    ) {
    }

    public function __invoke(CreateEventCommand $command)
    {
        $event = new Event(
            $command->eventId,
            $command->title,
            $command->description,
            $command->location,
            $command->startsAt,
            $command->endsAt,
        );

        $this->eventRepository->add($event);

        $ticketTypes = array_map(function (TicketTypeRequest $ticketTypeRequest) use ($event) {
            return new TicketType(
                $ticketTypeRequest->ticketTypeId,
                $event,
                $ticketTypeRequest->name,
                $ticketTypeRequest->price,
                $ticketTypeRequest->currency,
                $ticketTypeRequest->quantity,
            );
        }, $command->ticketTypes);

        $this->ticketTypeRepository->addBatch($ticketTypes);
    }
}
