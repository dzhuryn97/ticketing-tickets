<?php

namespace App\Presenter\DataFixtures\Test;

use App\Application\Customer\CreateCustomer\CreateCustomerCommand;
use App\Presenter\DataFixtures\BaseFixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CustomerFixtures extends BaseFixture implements FixtureGroupInterface
{
    public const CUSTOMER1_ID = '8e3270e3-c7b9-4969-b5f5-a8469906eb72';

    public function load(ObjectManager $manager): void
    {
        $this->commandBus->dispatch(
            new CreateCustomerCommand(
                Uuid::fromString(self::CUSTOMER1_ID),
                $this->faker->name(),
                $this->faker->email()
            )
        );
        //        $manager->persist($customer);
        //        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
