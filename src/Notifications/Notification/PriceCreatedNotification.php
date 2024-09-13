<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Price;
use Paddle\SDK\Notifications\Events\PriceCreated;
use Paddle\SDK\Notifications\Notification;

final class PriceCreatedNotification extends Notification
{
    public readonly Price $price;

    private function __construct(string $id, PriceCreated $event)
    {
        $this->price = $event->price;

        parent::__construct($id, $event);
    }

    /**
     * @param PriceCreated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
