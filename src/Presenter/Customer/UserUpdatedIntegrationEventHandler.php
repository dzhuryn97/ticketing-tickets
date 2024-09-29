<?php

namespace App\Presenter\Customer;

use App\Application\Customer\UpdateCustomer\UpdateCustomerCommand;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\EventBus\IntegrationEventHandlerInterface;
use Ticketing\Common\IntegrationEvent\User\UserUpdatedIntegrationEvent;

class UserUpdatedIntegrationEventHandler implements IntegrationEventHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(
        UserUpdatedIntegrationEvent $event,
    ) {
        $this->commandBus->dispatch(
            new UpdateCustomerCommand(
                $event->userId,
                $event->name,
                $event->email,
            )
        );
    }
}
