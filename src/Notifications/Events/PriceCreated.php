<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Events;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\PriceWithIncludes;

final class PriceCreated extends Event
{
    public function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        PriceWithIncludes $data,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $data);
    }
}
