<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\Subscription;

final class SubscriptionCreated extends Event
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        public readonly Subscription $subscription,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $subscription);
    }

    /**
     * @param Subscription $data
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
