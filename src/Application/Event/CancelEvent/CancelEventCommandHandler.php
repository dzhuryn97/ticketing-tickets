<?php

namespace App\Application\Event\CancelEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Order\OrderRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;
use Ticketing\Common\Infrastructure\Flusher;

class CancelEventCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly FlusherInterface $flusher
    )
    {
    }

    public function __invoke(CancelEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if(!$event){
            throw new EventNotFoundException($command->eventId);
        }
        $event->cancel();
        $this->flusher->flush();
    }
}