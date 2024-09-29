<?php

namespace App\Application\Ticket\ArchiveTicketsForEvent;

use App\Domain\Event\EventTicketsArchivedDomainEvent;
use Ticketing\Common\Application\DomainEventHandlerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\IntegrationEvent\Ticket\EventTicketsArchivedIntegrationEvent;

class EventTicketsArchivedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(EventTicketsArchivedDomainEvent $event)
    {
        $this->eventBus->publish(
            new EventTicketsArchivedIntegrationEvent(
                $event->id,
                $event->occurredOn,
                $event->eventId,
            )
        );
    }
}
