<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Subscription;
use Paddle\SDK\Notifications\Events\SubscriptionImported;
use Paddle\SDK\Notifications\Notification;

final class SubscriptionImportedNotification extends Notification
{
    public readonly Subscription $subscription;

    private function __construct(string $id, SubscriptionImported $event)
    {
        $this->subscription = $event->subscription;

        parent::__construct($id, $event);
    }

    /**
     * @param SubscriptionImported $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
