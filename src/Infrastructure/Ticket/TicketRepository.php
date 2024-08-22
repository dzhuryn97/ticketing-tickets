<?php

namespace App\Infrastructure\Ticket;

use App\Domain\Event\Event;
use App\Domain\Payment\Payment;
use App\Domain\Ticket\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class TicketRepository extends ServiceEntityRepository implements \App\Domain\Ticket\TicketRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
        $this->em = $this->getEntityManager();
    }

    /**
     * @inheritDoc
     */
    public function getForEvent(Event $event): array
    {

        return $this->findBy(['event' => $event]);
    }

    /**
     * @inheritDoc
     */
    public function addBatch(array $tickets): void
    {
        foreach ($tickets as $ticket) {
            $this->em->persist($ticket);
        }
    }

    public function findById(UuidInterface $ticketId):?Ticket
    {
        return $this->find($ticketId);
    }
}