<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Business;
use Paddle\SDK\Notifications\Events\BusinessUpdated;
use Paddle\SDK\Notifications\Notification;

final class BusinessUpdatedNotification extends Notification
{
    public readonly Business $business;

    private function __construct(string $id, BusinessUpdated $event)
    {
        $this->business = $event->business;

        parent::__construct($id, $event);
    }

    /**
     * @param BusinessUpdated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
