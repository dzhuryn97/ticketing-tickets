<?php

namespace App\Application\Ticket\CreateTicketBatch;

use App\Domain\Ticket\Exception\TicketNotFoundException;
use App\Domain\Ticket\TicketCreatedDomainEvent;
use App\Domain\Ticket\TicketRepositoryInterface;
use Ticketing\Common\Application\DomainEventHandlerInterface;
use Ticketing\Common\Application\EventBus\EventBusInterface;
use Ticketing\Common\IntegrationEvent\Ticket\TicketIssuedIntegrationEvent;

class TicketCreatedDomainEventHandler implements DomainEventHandlerInterface
{
    public function __construct(
        private readonly TicketRepositoryInterface $ticketRepository,
        private readonly EventBusInterface         $eventBus
    )
    {
    }

    public function __invoke(TicketCreatedDomainEvent $event)
    {
        $ticket = $this->ticketRepository->findById($event->ticketId);

        if (!$ticket) {
            throw new TicketNotFoundException($event->ticketId);
        }

        $this->eventBus->publish(new TicketIssuedIntegrationEvent(
            $event->id,
            $event->occurredOn,
            $ticket->getId(),
            $ticket->getCustomer()->getId(),
            $ticket->getEvent()->getId(),
            $ticket->getCode(),
        ));
    }
}