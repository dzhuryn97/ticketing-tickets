<?php

namespace App\Domain\Payment;

use App\Domain\Order\Order;
use App\Domain\Payment\Exception\PaymentAlreadyRefundedException;
use App\Domain\Payment\Exception\PaymentNotEnoughFundsException;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Ticketing\Common\Domain\DomainEntity;

#[ORM\Entity]
class Payment extends DomainEntity
{

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    public Order $order;
    #[ORM\Column(type: 'uuid')]
    public UuidInterface $transactionId;
    #[ORM\Column]
    public float $amount;
    #[ORM\Column]
    public string $currency;
    #[ORM\Column(nullable: true)]
    public ?float $amountRefunded;
    #[ORM\Column]
    public \DateTimeImmutable $createdAt;
    #[ORM\Column(nullable: true)]
    public ?\DateTimeImmutable $refundedAt;


    public function __construct(
        Order $order,
        UuidInterface $transactionId,
        float $amount,
        string $currency
    )
    {
        $this->id = Uuid::uuid4();
        $this->order = $order;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->createdAt = new \DateTimeImmutable();

        $this->raiseDomainEvent(new PaymentCreatedDomainEvent($this->id));
    }

    public function refund(float $refundAmount)
    {
        if ($this->amountRefunded == $this->amount) {
            throw new PaymentAlreadyRefundedException();
        }

        if ($this->amountRefunded + $refundAmount > $this->amount) {
            throw new PaymentNotEnoughFundsException();
        }

        $this->amountRefunded += $refundAmount;

        if ($this->amount == $this->amountRefunded) {
            $this->raiseDomainEvent(new PaymentRefundedDomainEvent($this->id, $this->transactionId, $refundAmount));
        } else {
            $this->raiseDomainEvent(new PaymentPartiallyRefundedDomainEvent($this->id, $this->transactionId, $refundAmount));
        }


    }


}