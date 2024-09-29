<?php

namespace App\Infrastructure\Event;

use App\Domain\Event\Event;
use App\Domain\Event\EventRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class EventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(UuidInterface $eventId): ?Event
    {
        return $this->find($eventId);
    }

    public function add(Event $event): void
    {
        $this->em->persist($event);
    }
}
