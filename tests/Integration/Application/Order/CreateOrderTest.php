<?php

namespace App\Tests\Integration\Application\Order;

use App\Application\Cart\AddItemToCart\AddItemToCartCommand;
use App\Application\Order\CreateOrder\CreateOrderCommand;
use App\Application\Order\CreateOrder\CreateOrderCommandHandler;
use App\Application\Ticket\CreateTicketBatch\CreateTicketBatchCommand;
use App\Presenter\DataFixtures\Test\CustomerFixtures;
use App\Presenter\DataFixtures\Test\EventFixture;
use App\Tests\Integration\AbstractIntegrationTestCase;
use Ramsey\Uuid\Uuid;
use Ticketing\Common\Application\Command\CommandBusInterface;

class CreateOrderTest extends AbstractIntegrationTestCase
{
    //    /**
    //     * @test
    //     */
    //    public function ShouldFail_WhenCartIsEmpty()
    //    {
    //        //Arrange
    //        self::bootKernel();
    //        $container = static::getContainer();
    //
    //        $command = new CreateOrderCommand(
    //            Uuid::fromString(CustomerFixtures::CUSTOMER1_ID)
    //        );
    //        $createOrderCommandHandler = $container->get(CreateOrderCommandHandler::class);
    //
    //        //Assert
    //        $this->expectException(CartIsEmptyException::class);
    //
    //        //Act
    //        $createOrderCommandHandler($command);
    //    }

    /**
     * @test
     */
    public function shouldSuccess()
    {
        // Arrange
        self::bootKernel();
        $container = static::getContainer();

        $customerId = Uuid::fromString(CustomerFixtures::CUSTOMER1_ID);

        $command = new CreateOrderCommand(
            Uuid::fromString(CustomerFixtures::CUSTOMER1_ID)
        );
        /** @var CommandBusInterface $commandBus */
        $commandBus = $container->get(CommandBusInterface::class);

        //        $commandBus->dispatch(new CreateTicketBatchCommand(
        //            Uuid::fromString('7d7f1c7a-9c9a-4377-8e6d-1c48b2e03c4a')
        //        ));
        //
        $commandBus->dispatch(
            new AddItemToCartCommand(
                $customerId,
                Uuid::fromString(EventFixture::TICKET_TYPE1_ID),
                $cartItem1Quantity = 1
            )
        );

        $commandBus->dispatch(
            new AddItemToCartCommand(
                $customerId,
                Uuid::fromString(EventFixture::TICKET_TYPE2_ID),
                $cartItem2Quantity = 2
            )
        );

        $totalPrice = $cartItem1Quantity * EventFixture::TICKET_TYPE1_PRICE + $cartItem2Quantity * EventFixture::TICKET_TYPE2_PRICE;
        $createOrderCommandHandler = $container->get(CreateOrderCommandHandler::class);

        // Act
        $orderId = $createOrderCommandHandler($command);
        //        dump($orderId);

    }
}
