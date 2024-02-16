<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\Transaction;

final class TransactionPaymentFailed extends Event
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Transaction $data,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $data);
    }

    /**
     * @param Transaction $data
     */
    public static function fromEvent(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Entity $data,
    ): static {
        return new self($eventId, $eventType, $occurredAt, $data);
    }
}
