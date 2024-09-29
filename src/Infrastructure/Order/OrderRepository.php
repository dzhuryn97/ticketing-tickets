<?php

namespace App\Infrastructure\Order;

use App\Domain\Order\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class OrderRepository extends ServiceEntityRepository implements \App\Domain\Order\OrderRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
        $this->em = $this->getEntityManager();
    }

    public function findById(UuidInterface $orderId): ?Order
    {
        return $this->find($orderId);
    }

    public function add(Order $order): void
    {
        $this->em->persist($order);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }
}
