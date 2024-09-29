<?php

namespace App\Application\Order\CreateOrder;

use App\Application\Ticket\CreateTicketBatch\CreateTicketBatchCommand;
use App\Domain\Order\OrderCreatedDomainEvent;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\DomainEventHandlerInterface;

class CreateTicketsOrderCreatedDomainEventHandler implements DomainEventHandlerInterface
{
    private CommandBusInterface $commandBus;

    public function __construct(
        CommandBusInterface $commandBus,
    ) {
        $this->commandBus = $commandBus;
    }

    public function __invoke(
        OrderCreatedDomainEvent $event,
    ) {
        $this->commandBus->dispatch(
            new CreateTicketBatchCommand($event->orderId)
        );
    }
}
