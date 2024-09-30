<?php

namespace App\Application\Ticket\CreateTicketBatch;

use App\Domain\Order\Exception\OrderNotFoundException;
use App\Domain\Order\OrderRepositoryInterface;
use App\Domain\Ticket\Ticket;
use App\Domain\Ticket\TicketRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\UnitOfWork;

class CreateTicketBatchCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly TicketRepositoryInterface $ticketRepository,
        private readonly UnitOfWork $unitOfWork,
    ) {
    }

    public function __invoke(CreateTicketBatchCommand $command)
    {
        $order = $this->orderRepository->findById($command->orderId);
        if (!$order) {
            throw new OrderNotFoundException($command->orderId);
        }

        $this->unitOfWork->beginTransaction();

        $order->issueTickets();
        $this->orderRepository->save($order);

        $tickets = [];
        foreach ($order->getOrderItems() as $orderItem) {
            $ticketType = $orderItem->getTicketType();

            for ($i = 0; $i < $orderItem->getQuantity(); ++$i) {
                $tickets[] = new Ticket($order, $ticketType);
                break;
            }
            break;
        }

        $this->ticketRepository->addBatch($tickets);

        $this->unitOfWork->commit();
    }
}
