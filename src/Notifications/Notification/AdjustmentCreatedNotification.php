<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Adjustment;
use Paddle\SDK\Notifications\Events\AdjustmentCreated;
use Paddle\SDK\Notifications\Notification;

final class AdjustmentCreatedNotification extends Notification
{
    public readonly Adjustment $adjustment;

    private function __construct(string $id, AdjustmentCreated $event)
    {
        $this->adjustment = $event->adjustment;

        parent::__construct($id, $event);
    }

    /**
     * @param AdjustmentCreated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
