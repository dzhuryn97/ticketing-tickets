<?php

namespace App\Tests\Unit\Domain\Event;

use App\Domain\Event\Event;
use App\Domain\Event\Exception\TicketTypeNotEnoughQuantityException;
use App\Domain\Event\TicketType;
use App\Domain\Event\TicketTypeSoldOutDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;

class TicketTypeTest extends AbstractTestCase
{
    #[Test]
    public function UpdateQuantity_ShouldFail_WhenQuantityNotEnough()
    {
        // Arrange
        $event = new Event(
            Uuid::uuid4(),
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $quantity = 10;
        $ticketType = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $quantity
        );

        // Act
        $this->expectException(TicketTypeNotEnoughQuantityException::class);
        $ticketType->updateQuantity(11);
    }

    #[Test]
    public function UpdateQuantity_ShouldRaiseDomainEvent_WhenAvailableQuantityEnded()
    {
        // Arrange
        $event = new Event(
            Uuid::uuid4(),
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $quantity = 10;
        $ticketType = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $quantity
        );

        // Act
        $ticketType->updateQuantity(10);

        // Assert
        $this->assertDomainEventRaised($ticketType, TicketTypeSoldOutDomainEvent::class);
    }

    #[Test]
    public function UpdateQuantity_ShouldSuccess()
    {
        // Arrange
        $event = new Event(
            Uuid::uuid4(),
            $this->faker->title(),
            $this->faker->text(),
            $this->faker->text(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
        $quantity = 10;
        $ticketType = new TicketType(
            Uuid::uuid4(),
            $event,
            $this->faker->title(),
            $this->faker->randomDigit(),
            $this->faker->currencyCode(),
            $quantity
        );

        // Act
        $ticketType->updateQuantity(4);
        $ticketType->updateQuantity(2);

        // Assert
        $this->assertEquals(4, $ticketType->getAvailableQuantity());
    }
}
