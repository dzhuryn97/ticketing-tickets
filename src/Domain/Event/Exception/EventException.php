<?php

namespace App\Domain\Event\Exception;

use Ramsey\Uuid\UuidInterface;

class EventException extends \DomainException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }

    public static function notFound(UuidInterface $eventId)
    {
        return new self(sprintf('Event with identifier %s not found', $eventId));
    }
}
