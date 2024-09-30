<?php

namespace App\Tests\Integration;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Faker\Factory;
use Faker\Generator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\DependencyInjection\Container;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\Presenter\Symfony\Security\AuthUser;

abstract class AbstractIntegrationTestCase extends ApiTestCase
{
    protected Generator $faker;
    protected CommandBusInterface $commandBus;
    protected Container $container;

    protected function setUp(): void
    {
        // TODO avoid AD-hoc of clearing cart cache
        (new \Symfony\Component\Filesystem\Filesystem())->remove(__DIR__.'/../../var/cache/test/pools/app');

        self::bootKernel();
        $this->container = static::getContainer();

        $this->faker = Factory::create();
        $this->commandBus = $this->container->get(CommandBusInterface::class);

        parent::setUp();
    }

    protected static function createClient(array $kernelOptions = [], array $defaultOptions = []): Client
    {
        if (!isset($defaultOptions['headers']['Content-type'])) {
            $defaultOptions['headers']['Content-type'] = 'application/ld+json';
        }

        return parent::createClient($kernelOptions, $defaultOptions);
    }

    protected function createClientWithCredentials($customerId = null): Client
    {
        $token = $this->createJWTToken($customerId);

        return self::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);
    }

    protected function createJWTToken(
        ?UuidInterface $customerId = null,
    ): string {
        if (!$customerId) {
            $customerId = Uuid::uuid4();
        }

        /** @var JWTTokenManagerInterface $jwtTokenManager */
        $jwtTokenManager = $this->container->get(JWTTokenManagerInterface::class);

        $user = new AuthUser(
            $customerId,
            $userName = 'test',
            []
        );

        return $jwtTokenManager->createFromPayload($user, ['name' => $userName]);
    }
}
