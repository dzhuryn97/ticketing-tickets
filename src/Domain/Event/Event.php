<?php

namespace App\Domain\Event;

use Doctrine\ORM\Mapping as Mapping;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[Mapping\Entity(
    repositoryClass: \App\Domain\Event\EventRepositoryInterface::class
)]
class Event extends DomainEntity
{

    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid')]
    private UuidInterface $id;
    #[Mapping\Column]
    private string $title;
    #[Mapping\Column]
    private string $description;
    #[Mapping\Column]
    private string $location;
    #[Mapping\Column]
    private \DateTimeImmutable $startsAt;
    #[Mapping\Column(nullable: true)]
    private ?\DateTimeImmutable $endsAt;
    #[Mapping\Column]
    private bool $canceled;

    public function __construct(
        UuidInterface       $eventId,
        string              $title,
        string              $description,
        string              $location,
        \DateTimeImmutable  $startsAt,
        ?\DateTimeImmutable $endsAt,
    )
    {
        $this->id = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->location = $location;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
        $this->canceled = false;
    }


    public function reschedule(
        \DateTimeImmutable  $startsAt,
        ?\DateTimeImmutable $endsAt,
    ): void
    {
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;

        $this->raiseDomainEvent(new EventRescheduledDomainEvent($this->id, $this->startsAt, $this->endsAt));
    }

    public function cancel()
    {
        if ($this->canceled) {
            return;
        }
        $this->canceled = true;
        $this->raiseDomainEvent(new EventCanceledDomainEvent($this->id));
    }

    public function paymentsRefunded(): void
    {
        $this->raiseDomainEvent(new EventPaymentsRefundedDomainEvent($this->id));
    }

    public function ticketsArchived(): void
    {
        $this->raiseDomainEvent(new EventTicketsArchivedDomainEvent($this->id));
    }
//
//  public void PaymentsRefunded()
//  {
//      Raise(new EventPaymentsRefundedDomainEvent(Id));
//    }
//
//    public void TicketsArchived()
//    {
//          Raise(new EventTicketsArchivedDomainEvent(Id));
//    }

}