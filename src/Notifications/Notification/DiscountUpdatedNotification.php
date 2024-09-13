<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Discount;
use Paddle\SDK\Notifications\Events\DiscountUpdated;
use Paddle\SDK\Notifications\Notification;

final class DiscountUpdatedNotification extends Notification
{
    public readonly Discount $discount;

    private function __construct(string $id, DiscountUpdated $event)
    {
        $this->discount = $event->discount;

        parent::__construct($id, $event);
    }

    /**
     * @param DiscountUpdated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
