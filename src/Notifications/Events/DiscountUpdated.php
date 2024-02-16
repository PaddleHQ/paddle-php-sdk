<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Discount;
use Paddle\SDK\Notifications\Entities\Entity;

final class DiscountUpdated extends Event
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Discount $data,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $data);
    }

    /**
     * @param Discount $data
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
