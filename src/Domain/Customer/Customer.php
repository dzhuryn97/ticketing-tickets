<?php

namespace App\Domain\Customer;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[Entity]
class Customer extends DomainEntity
{
    #[Id]
    #[Column(type: 'uuid')]
    private UuidInterface $id;
    #[Column]
    private string $name;
    #[Column]
    private string $email;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $email,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function update(
        string $name,
        string $email,
    ) {
        $this->name = $name;
        $this->email = $email;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
