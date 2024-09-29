<?php

namespace App\Infrastructure\Customer;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Customer $customer): void
    {
        $this->em->persist($customer);
    }

    public function findById(UuidInterface $customerId): ?Customer
    {
        return $this->find($customerId);
    }
}
