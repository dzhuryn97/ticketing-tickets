<?php

namespace App\Presenter\Customer;

use App\Application\Customer\CreateCustomer\CreateCustomerCommand;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Application\EventBus\IntegrationEventHandlerInterface;
use Ticketing\Common\IntegrationEvent\User\UserCreatedIntegrationEvent;

class UserCreatedIntegrationEventHandler implements IntegrationEventHandlerInterface
{

    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }

    public function __invoke(UserCreatedIntegrationEvent $event)
    {
       $this->commandBus->dispatch(
           new CreateCustomerCommand(
               $event->userId,
               $event->name,
               $event->email,
           )
       );
    }
}