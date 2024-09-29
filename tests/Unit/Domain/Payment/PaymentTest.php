<?php

namespace App\Tests\Unit\Domain\Payment;

use App\Domain\Customer\Customer;
use App\Domain\Order\Order;
use App\Domain\Payment\Exception\PaymentAlreadyRefundedException;
use App\Domain\Payment\Exception\PaymentNotEnoughFundsException;
use App\Domain\Payment\Payment;
use App\Domain\Payment\PaymentCreatedDomainEvent;
use App\Domain\Payment\PaymentPartiallyRefundedDomainEvent;
use App\Domain\Payment\PaymentRefundedDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;

class PaymentTest extends AbstractTestCase
{
    #[Test]
    public function Create_Success()
    {
        // Arrange
        $customer = new Customer(
            Uuid::uuid4(),
            $this->faker->name(),
            $this->faker->email(),
        );
        $order = new Order(
            $customer
        );

        // Act
        $payment = new Payment(
            $order,
            Uuid::uuid4(),
            700,
            'USD'
        );

        // Assert
        $this->assertDomainEventRaised($payment, PaymentCreatedDomainEvent::class);
    }

    #[Test]
    public function Refund_ShouldRaisePaymentRefunded_WhenRefundFullPrice()
    {
        // Arrange
        $customer = new Customer(
            Uuid::uuid4(),
            $this->faker->name(),
            $this->faker->email(),
        );
        $order = new Order(
            $customer
        );

        // Act
        $payment = new Payment(
            $order,
            Uuid::uuid4(),
            $paymentAmount = 700,
            'USD'
        );

        // Act
        $payment->refund(700);

        // Assert
        $this->assertDomainEventRaised($payment, PaymentRefundedDomainEvent::class);
    }

    #[Test]
    public function Refund_ShouldRaisePaymentPartiallyRefunded_WhenRefundPartialPrice()
    {
        // Arrange
        $customer = new Customer(
            Uuid::uuid4(),
            $this->faker->name(),
            $this->faker->email(),
        );
        $order = new Order(
            $customer
        );

        // Act
        $payment = new Payment(
            $order,
            Uuid::uuid4(),
            $paymentAmount = 700,
            'USD'
        );

        // Act
        $payment->refund(600);

        // Assert
        $this->assertDomainEventRaised($payment, PaymentPartiallyRefundedDomainEvent::class);
    }

    #[Test]
    public function Refund_ShouldFail_WhenPaymentAlreadyRefunded()
    {
        // Arrange
        $customer = new Customer(
            Uuid::uuid4(),
            $this->faker->name(),
            $this->faker->email(),
        );
        $order = new Order(
            $customer
        );
        $payment = new Payment(
            $order,
            Uuid::uuid4(),
            $paymentAmount = 700,
            'USD'
        );
        $payment->refund($paymentAmount);

        // Act
        $this->expectException(PaymentAlreadyRefundedException::class);
        $payment->refund(600);

    }

    #[Test]
    public function Refund_ShouldFail_WhenRefundMoreThenRemains()
    {
        // Arrange
        $customer = new Customer(
            Uuid::uuid4(),
            $this->faker->name(),
            $this->faker->email(),
        );
        $order = new Order(
            $customer
        );
        $payment = new Payment(
            $order,
            Uuid::uuid4(),
            $paymentAmount = 700,
            'USD'
        );
        $payment->refund(200);

        // Act
        $this->expectException(PaymentNotEnoughFundsException::class);
        $payment->refund(600);
    }
}
