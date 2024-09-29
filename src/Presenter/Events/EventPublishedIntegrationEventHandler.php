<?php

namespace App\Presenter\Events;

use App\Application\Event\CreateEvent\CreateEventCommand;
use App\Application\Event\CreateEvent\TicketTypeRequest;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\EventBus\IntegrationEventHandlerInterface;
use Ticketing\Common\IntegrationEvent\Event\EventPublishedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\Event\TicketTypeModel;

class EventPublishedIntegrationEventHandler implements IntegrationEventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(EventPublishedIntegrationEvent $event)
    {
        $this->commandBus->dispatch(
            new CreateEventCommand(
                $event->eventId,
                $event->title,
                $event->description,
                $event->location,
                $event->startsAt,
                $event->endsAt,
                array_map(function (TicketTypeModel $ticketTypeModel) {
                    return new TicketTypeRequest(
                        $ticketTypeModel->id,
                        $ticketTypeModel->eventId,
                        $ticketTypeModel->name,
                        $ticketTypeModel->price,
                        $ticketTypeModel->currency,
                        $ticketTypeModel->quantity,
                    );
                }, $event->ticketsType)
            )
        );
    }
}
