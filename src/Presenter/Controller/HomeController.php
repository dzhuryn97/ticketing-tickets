<?php

namespace App\Presenter\Controller;

use App\Application\Cart\AddItemToCart\AddItemToCartCommand;
use App\Application\Cart\Cart;
use App\Application\Cart\CartItem;
use App\Application\Cart\CartService;
use App\Application\Event\CreateEvent\CreateEventCommand;
use App\Application\Event\CreateEvent\TicketTypeRequest;
use App\Application\Order\CreateOrder\CreateOrderCommand;
use App\Application\Payment\RefundPaymentsForEvent\RefundPaymentsForEventCommand;
use App\Application\Ticket\ArchiveTicketsForEvent\ArchiveTicketsForEventCommand;
use App\Application\Ticket\CreateTicketBatch\CreateTicketBatchCommand;
use App\Presenter\Customer\UserCreatedIntegrationEventHandler;
use App\Presenter\Customer\UserUpdatedIntegrationEventHandler;
use Psr\Cache\CacheItemPoolInterface;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Ticketing\Common\Application\Command\CommandBusInterface;
use Ticketing\Common\IntegrationEvent\User\UserCreatedIntegrationEvent;
use Ticketing\Common\IntegrationEvent\User\UserUpdatedIntegrationEvent;

class HomeController extends AbstractController
{

    public function __construct(

    )
    {
    }

    #[Route('/api/tickets/test')]
    public function index(
        UserCreatedIntegrationEventHandler $handler,
        UserUpdatedIntegrationEventHandler $updatedIntegrationEventHandler,
        CartService $cartService,
        CommandBusInterface $commandBus
    )
    {
//        $orderId = Uuid::fromString('b1c94806-e8cf-4484-a82f-7d019c90f06f');
//
//        $commandBus->dispatch(
//            new CreateTicketBatchCommand($orderId)
//        );
//
//        dd('end');


        $eventId = Uuid::fromString('fb1f7cb1-4878-47d0-9040-a21bb035c47c');
        $customerId = Uuid::fromString('322594da-414d-421d-b8f9-7491e9fbc031');

                $ticketTypeId1 = UuidV4::fromString('a854045e-70b9-4b94-96f7-1b0bedcf004c');
        $ticketTypeId2 = UuidV4::fromString('a33ff24a-a29e-4401-a5f5-8e7dabd965a7');

        $commandBus->dispatch(new RefundPaymentsForEventCommand($eventId));


        dd('end2');

        //create event
//        $commandBus->dispatch(
//            new CreateEventCommand(
//                $eventId,
//                'My event',
//                'desc',
//                'loc',
//                new \DateTimeImmutable(),
//                null,
//                [
//                    new TicketTypeRequest(
//                        Uuid::uuid4(),
//                        $eventId,
//                        'fan',
//                        500,
//                        'UAH',
//                        100
//                    ),
//                    new TicketTypeRequest(
//                        Uuid::uuid4(),
//                        $eventId,
//                        'vip',
//                        1500,
//                        'UAH',
//                        50
//                    )
//                ]
//            )
//        );

        //add tickets to cart

        foreach ([$ticketTypeId1, $ticketTypeId2] as $ticketTypeId) {
           $commandBus->dispatch(
               new AddItemToCartCommand(
                   $customerId,
                   $ticketTypeId,
                   rand(1,5)
               )
           );
        }


        $commandBus->dispatch(
            new CreateOrderCommand($customerId)
        );

        dd('order created');


//        $customerId = UuidV4::fromString('cc2a1c1e-7e57-4399-94e6-abc6a33773c6');
//
//        $ticketTypeId1 = UuidV4::fromString('84e328eb-e19e-4515-9d35-14e9fb3a5471');
//        $ticketTypeId2 = UuidV4::fromString('3dfb78ad-42d2-4394-b81e-40fd5acce631');
//
//
//        $cartItem = new CartItem(
//            $ticketTypeId2,
//            2,
//            '500',
//            'USD'
//        );
//
//        $cartService->addItem($customerId,$cartItem);
//
//
//        $cart = $cartService->getCart($customerId);
//        dump($cart->items);
//
////        $cartService->clear($customerId);
//        dd('end');

//        $cacheItem = $appCache->getItem('test2');
////        $cacheItem->set(new Cart($customerId));
//        dump($cacheItem->get());
//
////        $appCache->save($cacheItem);
//
//        dd('end');

//
//
//
//        $result = $cache->get('test', function () use($customerId){
//            $cart = new Cart($customerId);
//
//            return $cart;
//        });
//
//        /** @var Cart $result */
//        dd($result->customerId);
//
//        dd($cache);
//        $updatedIntegrationEventHandler(
//            new UserUpdatedIntegrationEvent(
//                UuidV4::uuid4(),
//                new \DateTimeImmutable(),
//                UuidV4::fromString('44972d13-de14-4bc0-b5c4-b129976e3d33'),
//                'name2',
//                'asdf2@dafs.dsf'
//            )
//        );
        dd('test');
    }
}