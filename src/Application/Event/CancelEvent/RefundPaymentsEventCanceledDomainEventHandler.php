<?php

namespace App\Application\Event\CancelEvent;

use App\Application\Payment\RefundPaymentsForEvent\RefundPaymentsForEventCommand;
use App\Domain\Event\EventCanceledDomainEvent;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\DomainEventHandlerInterface;

class RefundPaymentsEventCanceledDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(EventCanceledDomainEvent $event)
    {
        $this->commandBus->dispatch(new RefundPaymentsForEventCommand($event->eventId));
    }
}
