<?php

namespace App\Application\Event\CancelEvent;

use App\Application\Ticket\ArchiveTicketsForEvent\ArchiveTicketsForEventCommand;
use App\Domain\Event\EventCanceledDomainEvent;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\DomainEventHandlerInterface;

class ArchiveTicketsEventCanceledDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(EventCanceledDomainEvent $event)
    {
        $this->commandBus->dispatch(new ArchiveTicketsForEventCommand($event->eventId));
    }
}
