<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Business;

final class BusinessUpdated extends Event
{
    public function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Business $data,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $data);
    }
}
