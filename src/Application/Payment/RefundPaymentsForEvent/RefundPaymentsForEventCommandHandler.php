<?php

namespace App\Application\Payment\RefundPaymentsForEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Payment\PaymentRepositoryInterface;
use App\Domain\Ticket\TicketRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class RefundPaymentsForEventCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly PaymentRepositoryInterface $paymentRepository,
        private readonly FlusherInterface $flusher
    )
    {
    }

    public function __invoke(RefundPaymentsForEventCommand $command)
    {
        $event = $this->eventRepository->findById($command->eventId);
        if(!$event){
            throw new EventNotFoundException($command->eventId);
        }

        $payments = $this->paymentRepository->getForEvent($event);

        foreach ($payments as $payment) {
            $amountToRefund = $payment->amount - $payment->amountRefunded;
            $payment->refund($amountToRefund);
        }

        $event->paymentsRefunded();
        $this->flusher->flush();
    }
}