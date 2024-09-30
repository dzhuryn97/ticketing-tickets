<?php

namespace App\Presenter\Events;

use App\Application\Event\CancelEvent\CancelEventCommand;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\EventBus\IntegrationEventHandlerInterface;
use Ticketing\Common\IntegrationEvent\Event\EventCancellationStartedIntegrationEvent;

class EventCancellationStartedIntegrationEventHandler implements IntegrationEventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(EventCancellationStartedIntegrationEvent $event)
    {
        $this->commandBus->dispatch(
            new CancelEventCommand(
                $event->eventId
            )
        );
    }
}
