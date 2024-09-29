<?php

namespace App\Application\Order\CreateOrder;

use App\Application\Cart\CartService;
use App\Application\Cart\Exception\CartIsEmptyException;
use App\Application\Payment\PaymentServiceInterface;
use App\Domain\Customer\CustomerRepositoryInterface;
use App\Domain\Customer\Exception\CustomerNotFoundException;
use App\Domain\Event\Exception\TicketTypeNotFoundException;
use App\Domain\Event\TicketTypeRepositoryInterface;
use App\Domain\Order\Order;
use App\Domain\Order\OrderRepositoryInterface;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentRepositoryInterface;
use Ticketing\Common\Application\Command\CommandHandlerInterface;
use Ticketing\Common\Application\FlusherInterface;

class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly TicketTypeRepositoryInterface $ticketTypeRepository,
        private readonly PaymentRepositoryInterface $paymentRepository,
        private readonly PaymentServiceInterface $paymentService,
        private readonly CartService $cartService,
        private readonly FlusherInterface $flusher,
    ) {
    }

    public function __invoke(CreateOrderCommand $command)
    {
        $this->flusher->beginTransaction();

        $customer = $this->customerRepository->findById($command->customerId);

        if (!$customer) {
            throw new CustomerNotFoundException($command->customerId);
        }

        $order = new Order($customer);

        $cart = $this->cartService->getCart($command->customerId);
        if ($cart->items->isEmpty()) {
            throw new CartIsEmptyException();
        }

        foreach ($cart->items as $cartItem) {
            $ticketType = $this->ticketTypeRepository->findWithLock($cartItem->ticketTypeId);
            if (!$ticketType) {
                throw new TicketTypeNotFoundException($cartItem->ticketTypeId);
            }

            $ticketType->updateQuantity($cartItem->quantity);

            $order->addItem($ticketType, $cartItem->quantity, $cartItem->price, $cartItem->currency);
        }

        $this->orderRepository->add($order);

        $paymentResponse = $this->paymentService->charge($order->getTotalPrice(), $order->getCurrency());

        $payment = new Payment(
            $order,
            $paymentResponse->transactionId,
            $paymentResponse->amount,
            $paymentResponse->currency,
        );

        $this->paymentRepository->add($payment);

        $this->flusher->flush();
        $this->flusher->commit();

        $this->cartService->clear($customer->getId());

        return $order->getId();
    }
}
