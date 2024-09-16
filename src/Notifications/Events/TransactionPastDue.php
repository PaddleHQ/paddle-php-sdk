<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\Transaction;

class TransactionPastDue extends Event
{
    protected function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        public readonly Transaction $transaction,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $transaction);
    }

    /**
     * @param Transaction $data
     */
    public static function fromEvent(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Entity $data,
    ): self {
        return new self($eventId, $eventType, $occurredAt, $data);
    }
}
