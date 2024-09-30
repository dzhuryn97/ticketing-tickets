<?php

namespace App\Tests\Integration\Application\Cart;

use App\Presenter\DataFixtures\Test\CustomerFixtures;
use App\Presenter\DataFixtures\Test\EventFixture;
use App\Tests\Integration\AbstractIntegrationTestCase;
use Ramsey\Uuid\Uuid;

class CartTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function addItemReturnNotAuthorizedWhenCalledWithoutCredentials()
    {
        $client = $this->createClient();

        $client->request('POST', '/api/tickets/carts', [
            'json' => [
                'ticketTypeId' => '43519428-1cea-4a33-b7fe-2e40566b2bb9',
                'quantity' => 4,
            ],
        ]);
        $this->assertResponseStatusCodeSame(401);
    }

    /**
     * @test
     */
    public function addItemAddItemToCartWhenCalled()
    {
        $client = $this->createClientWithCredentials(Uuid::fromString(CustomerFixtures::CUSTOMER1_ID));

        $client->request('POST', '/api/tickets/carts', [
            'json' => [
                'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                'quantity' => 4,
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'items' => [
                [
                    'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                    'quantity' => 4,
                ],
            ],
        ]);

    }

    /**
     * @test
     */
    public function addItemUpdateItemInCartItemInCartExists()
    {
        // Arrange
        $client = $this->createClientWithCredentials(Uuid::fromString(CustomerFixtures::CUSTOMER1_ID));

        $client->request('POST', '/api/tickets/carts', [
            'json' => [
                'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                'quantity' => $existCount = 4,
            ],
        ]);

        // Act
        $client->request('POST', '/api/tickets/carts', [
            'json' => [
                'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                'quantity' => $addRequestCount = 3,
            ],
        ]);

        // Assert
        $totalCount = $existCount + $addRequestCount;

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'items' => [
                [
                    'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                    'quantity' => $totalCount,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function addItemAddSecondItemInCartOtherItemInCartExists()
    {
        // Arrange
        $client = $this->createClientWithCredentials(Uuid::fromString(CustomerFixtures::CUSTOMER1_ID));

        $client->request('POST', '/api/tickets/carts', [
            'json' => [
                'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                'quantity' => $ticketType1Count = 4,
            ],
        ]);

        // Act
        $client->request('POST', '/api/tickets/carts', [
            'json' => [
                'ticketTypeId' => EventFixture::TICKET_TYPE2_ID,
                'quantity' => $ticketType2Count = 3,
            ],
        ]);

        // Assert
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'items' => [
                [
                    'ticketTypeId' => EventFixture::TICKET_TYPE1_ID,
                    'quantity' => $ticketType1Count,
                ],
                [
                    'ticketTypeId' => EventFixture::TICKET_TYPE2_ID,
                    'quantity' => $ticketType2Count,
                ],
            ],
        ]);
    }
}
