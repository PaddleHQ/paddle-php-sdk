<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Address;
use Paddle\SDK\Notifications\Entities\Entity;

final class AddressUpdated extends Event
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Address $data,
        string|null $notificationId,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $data, $notificationId);
    }

    /**
     * @param Address $data
     */
    public static function fromEvent(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Entity $data,
        string|null $notificationId = null,
    ): static {
        return new self($eventId, $eventType, $occurredAt, $data, $notificationId);
    }
}
