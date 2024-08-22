<?php

namespace App\Application\Payment\RefundPaymentsForEvent;

use App\Domain\Event\EventPaymentsRefundedDomainEvent;
use Ticketing\Common\Application\DomainEventHandlerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\IntegrationEvent\Ticket\EventPaymentsRefundedIntegrationEvent;

class EventPaymentsRefundedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly EventBusInterface $eventBus
    )
    {
    }

    public function __invoke(EventPaymentsRefundedDomainEvent $event)
    {
        $this->eventBus->publish(
            new EventPaymentsRefundedIntegrationEvent(
                $event->id,
                $event->occurredOn,
                $event->eventId
            )
        );
        // TODO: Implement __invoke() method.
    }
}