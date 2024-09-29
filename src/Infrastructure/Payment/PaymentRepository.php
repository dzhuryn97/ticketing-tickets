<?php

namespace App\Infrastructure\Payment;

use App\Domain\Event\Event;
use App\Domain\Payment\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class PaymentRepository extends ServiceEntityRepository implements \App\Domain\Payment\PaymentRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(UuidInterface $paymentId): ?Payment
    {
        return $this->find($paymentId);
    }

    public function getForEvent(Event $event): array
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->join('p.order', 'o')
            ->join('o.orderItems', 'oa')
            ->join('oa.ticketType', 'tt')
            ->where('tt.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getResult()
        ;
    }

    public function add(Payment $payment): void
    {
        $this->em->persist($payment);
    }
}
