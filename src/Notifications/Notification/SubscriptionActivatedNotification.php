<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Subscription;
use Paddle\SDK\Notifications\Events\SubscriptionActivated;
use Paddle\SDK\Notifications\Notification;

final class SubscriptionActivatedNotification extends Notification
{
    public readonly Subscription $subscription;

    private function __construct(string $id, SubscriptionActivated $event)
    {
        $this->subscription = $event->subscription;

        parent::__construct($id, $event);
    }

    /**
     * @param SubscriptionActivated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
