<?php

namespace App\Tests\Unit\Domain\Order;

use App\Domain\Customer\Customer;
use App\Domain\Event\Event;
use App\Domain\Event\TicketType;
use App\Domain\Order\Order;
use App\Domain\Order\OrderCreatedDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;

class OrderTest extends AbstractTestCase
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

        // Act
        $order = new Order(
            $customer
        );

        // Assert
        $this->assertDomainEventRaised($order, OrderCreatedDomainEvent::class);
    }

    #[Test]
    public function AddItem_Success()
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

        $event = new Event(
            Uuid::uuid4(),
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $ticketType1 = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $this->faker->randomDigit()
        );

        $ticketType2 = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $this->faker->randomDigit()
        );

        $orderItem1Quantity = 4;
        $orderItem1Price = 300;
        $orderItem1Currency = 'USD';

        $orderItem2Quantity = 3;
        $orderItem2Price = 400;
        $orderItem2Currency = 'UAH';


        // Act
        $order->addItem($ticketType1, $orderItem1Quantity, $orderItem1Price, $orderItem1Currency);
        $order->addItem($ticketType2, $orderItem2Quantity, $orderItem2Price, $orderItem2Currency);

        $this->assertEquals(2400, $order->getTotalPrice());
        $this->assertEquals($orderItem2Currency, $order->getCurrency());
    }
}
