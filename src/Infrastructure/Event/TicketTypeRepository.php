<?php

namespace App\Infrastructure\Event;

use AllowDynamicProperties;
use App\Domain\Event\TicketType;
use App\Domain\Event\TicketTypeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Cache\Lock;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class TicketTypeRepository extends ServiceEntityRepository implements TicketTypeRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketType::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(UuidInterface $ticketTypeId): ?TicketType
    {
        return  $this->find($ticketTypeId);
    }

    public function addBatch(array $ticketTypes): void
    {
        foreach ($ticketTypes as $ticketType) {
            $this->em->persist($ticketType);
        }
    }

    public function findWithLock(UuidInterface $ticketTypeId): ?TicketType
    {
        $qb = $this->createQueryBuilder('tt');
        return  $qb->where('tt.id = :ticketTypeId')
            ->setParameter('ticketTypeId', $ticketTypeId)
            ->getQuery()
            ->setLockMode(LockMode::PESSIMISTIC_WRITE)
            ->getOneOrNullResult();
    }
}