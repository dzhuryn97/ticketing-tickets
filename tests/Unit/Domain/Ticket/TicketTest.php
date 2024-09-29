<?php

namespace App\Tests\Unit\Domain\Ticket;

use App\Domain\Customer\Customer;
use App\Domain\Event\Event;
use App\Domain\Event\TicketType;
use App\Domain\Order\Order;
use App\Domain\Ticket\Ticket;
use App\Domain\Ticket\TicketArchivedDomainEvent;
use App\Domain\Ticket\TicketCreatedDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;

#[CoversClass(Ticket::class)]
class TicketTest extends AbstractTestCase
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

        $event = new Event(
            Uuid::uuid4(),
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $ticketType = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $this->faker->randomDigit()
        );

        // Act
        $ticket = new Ticket(
            $order,
            $ticketType
        );

        // Assert
        $this->assertDomainEventRaised($ticket, TicketCreatedDomainEvent::class);
        $this->assertNotEmpty($ticket->getCode());
    }

    #[Test]
    public function Archive_Success()
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
        $ticketType = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $this->faker->randomDigit()
        );

        $ticket = new Ticket(
            $order,
            $ticketType
        );
        $ticket->clearDomainEvents();

        // Act
        $ticket->archive();

        // Assert
        $this->assertDomainEventRaised($ticket, TicketArchivedDomainEvent::class);
        $this->assertTrue($ticket->isArchived());
    }
}
