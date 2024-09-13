<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Business;
use Paddle\SDK\Notifications\Entities\Entity;

final class BusinessCreated extends Event
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        public readonly Business $business,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $business);
    }

    /**
     * @param Business $data
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
