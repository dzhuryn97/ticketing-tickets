<?php

namespace App\Presenter\DataFixtures\Test;

use App\Application\Event\CreateEvent\CreateEventCommand;
use App\Application\Event\CreateEvent\TicketTypeRequest;
use App\Presenter\DataFixtures\BaseFixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class EventFixture extends BaseFixture implements FixtureGroupInterface
{
    public const EVENT1_ID = '9a9cbf81-71a1-4864-a71f-c6a6c5ac9da1';

    public const TICKET_TYPE1_ID = '82e5c497-c997-4d5c-b217-cf9f39f386a8';
    public const TICKET_TYPE1_PRICE = 430;
    public const TICKET_TYPE1_CURRENCY = 'USD';
    public const TICKET_TYPE1_QUANTITY = 50;

    public const TICKET_TYPE2_ID = 'b6b70d38-1721-4d35-84cf-d19aa890a6fb';
    public const TICKET_TYPE2_PRICE = 240;
    public const TICKET_TYPE2_CURRENCY = 'USD';
    public const TICKET_TYPE2_QUANTITY = 40;

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {
        $eventId = Uuid::fromString(self::EVENT1_ID);
        $this->commandBus->dispatch(
            new CreateEventCommand(
                $eventId,
                $this->faker->title(),
                $this->faker->text(),
                $this->faker->text(),
                new \DateTimeImmutable(),
                new \DateTimeImmutable(),
                [
                    new TicketTypeRequest(
                        Uuid::fromString(self::TICKET_TYPE1_ID),
                        $eventId,
                        $this->faker->title(),
                        self::TICKET_TYPE1_PRICE,
                        self::TICKET_TYPE1_CURRENCY,
                        self::TICKET_TYPE1_QUANTITY,
                    ),
                    new TicketTypeRequest(
                        Uuid::fromString(self::TICKET_TYPE2_ID),
                        $eventId,
                        $this->faker->title(),
                        self::TICKET_TYPE2_PRICE,
                        self::TICKET_TYPE2_CURRENCY,
                        self::TICKET_TYPE2_QUANTITY,
                    ),
                ]
            )
        );
    }
}
