<?php

namespace App\Presenter\Controller;

use App\Application\Ticket\CreateTicketBatch\CreateTicketBatchCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Ticketing\Common\Application\Command\CommandBusInterface;

class HomeController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route('/api/tickets/test')]
    public function index(
        CommandBusInterface $commandBus,
    ) {
        $commandBus->dispatch(
            new CreateTicketBatchCommand(
                //                Uuid::fromString('ae027dbc-9a32-4db1-97c1-ea31f3f78abb')
                Uuid::fromString('f3925d96-74e1-400c-9ee9-faa54b0c55a9')
            )
        );

        return $this->json('123');
    }
}
