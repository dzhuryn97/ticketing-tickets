<?php

namespace App\Tests\Unit\Domain\Event;

use App\Domain\Event\Event;
use App\Domain\Event\EventCanceledDomainEvent;
use App\Domain\Event\EventRescheduledDomainEvent;
use App\Tests\Unit\AbstractTestCase;
use PHPUnit\Framework\Attributes\Test;
use Ramsey\Uuid\Uuid;

class EventTest extends AbstractTestCase
{
    /** @test */
    public function rescheduleShouldSuccess()
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

        // Act
        $newStartsAt = new \DateTimeImmutable('+2 minutes');
        $newEndsAt = new \DateTimeImmutable('+5 minutes');

        $event->reschedule($newStartsAt, $newEndsAt);

        // Assert
        $this->assertTrue($event->getStartsAt() == $newStartsAt);
        $this->assertTrue($event->getEndsAt() == $newEndsAt);
        $this->assertDomainEventRaised($event, EventRescheduledDomainEvent::class);
    }

    /** @test */
    public function cancelShouldSuccess()
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

        // Act
        $event->cancel();


        // Assert
        $this->assertDomainEventRaised($event, EventCanceledDomainEvent::class);
    }
}
