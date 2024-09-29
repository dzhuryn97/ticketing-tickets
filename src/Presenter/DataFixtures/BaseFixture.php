<?php

namespace App\Presenter\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Ticketing\Common\Application\Command\CommandBusInterface;

abstract class BaseFixture extends Fixture
{
    protected \Faker\Generator $faker;

    public function __construct(
        protected readonly CommandBusInterface $commandBus,
    ) {
        $this->faker = Factory::create();
    }
}
