<?php

namespace App\Tests\Integration\Application\Order;

use App\Application\Cart\AddItemToCart\AddItemToCartCommand;
use App\Application\Order\CreateOrder\CreateOrderCommand;
use App\Application\Order\CreateOrder\CreateOrderCommandHandler;
use App\Presenter\DataFixtures\Test\CustomerFixtures;
use App\Presenter\DataFixtures\Test\EventFixture;
use App\Tests\Integration\AbstractIntegrationTestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreateOrderTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function createOrderShouldReturnOrderIdWhenCalled()
    {
        // Arrange
        $customerId = Uuid::fromString(CustomerFixtures::CUSTOMER1_ID);

        $createOrderCommand = new CreateOrderCommand(
            Uuid::fromString(CustomerFixtures::CUSTOMER1_ID)
        );

        $this->addItemToCart($customerId, Uuid::fromString(EventFixture::TICKET_TYPE1_ID), 5);

        $createOrderCommandHandler = $this->container->get(CreateOrderCommandHandler::class);

        // Act
        $orderId = $createOrderCommandHandler($createOrderCommand);

        // Assert
        $this->assertNotNull($orderId);
    }

    private function addItemToCart(UuidInterface $customerId, UuidInterface $ticketTypeId, int $quantity)
    {
        $this->commandBus->dispatch(
            new AddItemToCartCommand(
                $customerId,
                $ticketTypeId,
                $quantity
            )
        );
    }
}
