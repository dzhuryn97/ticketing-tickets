<?php

namespace App\Application\Payment\RefundPaymentsForEvent;

use App\Domain\Event\EventRepositoryInterface;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Payment\PaymentRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\UnitOfWork;

class RefundPaymentsForEventCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly PaymentRepositoryInterface $paymentRepository,
        private readonly UnitOfWork $unitOfWork,
    ) {
    }

    public function __invoke(RefundPaymentsForEventCommand $command)
    {
        $this->unitOfWork->beginTransaction();

        $event = $this->eventRepository->findById($command->eventId);
        if (!$event) {
            throw new EventNotFoundException($command->eventId);
        }

        $payments = $this->paymentRepository->getForEvent($event);

        foreach ($payments as $payment) {
            $amountToRefund = $payment->amount - $payment->amountRefunded;
            $payment->refund($amountToRefund);
            $this->paymentRepository->save($payment);
        }

        $event->paymentsRefunded();
        $this->eventRepository->save($event);

        $this->unitOfWork->commit();
    }
}
