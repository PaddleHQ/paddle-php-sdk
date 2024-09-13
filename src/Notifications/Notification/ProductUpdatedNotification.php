<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Product;
use Paddle\SDK\Notifications\Events\ProductUpdated;
use Paddle\SDK\Notifications\Notification;

final class ProductUpdatedNotification extends Notification
{
    public readonly Product $product;

    private function __construct(string $id, ProductUpdated $event)
    {
        $this->product = $event->product;

        parent::__construct($id, $event);
    }

    /**
     * @param ProductUpdated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
