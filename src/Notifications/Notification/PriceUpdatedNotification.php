<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Price;
use Paddle\SDK\Notifications\Events\PriceUpdated;
use Paddle\SDK\Notifications\Notification;

final class PriceUpdatedNotification extends Notification
{
    public readonly Price $price;

    private function __construct(string $id, PriceUpdated $event)
    {
        $this->price = $event->price;

        parent::__construct($id, $event);
    }

    /**
     * @param PriceUpdated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
