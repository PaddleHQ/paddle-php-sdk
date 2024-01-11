<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Adjustment;
use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;

final class AdjustmentUpdated extends Event
{
    public function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Adjustment $data,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $data);
    }
}
