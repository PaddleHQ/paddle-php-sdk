<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Payout;
use Paddle\SDK\Notifications\Events\PayoutCreated;
use Paddle\SDK\Notifications\Notification;

final class PayoutCreatedNotification extends Notification
{
    public readonly Payout $payout;

    private function __construct(string $id, PayoutCreated $event)
    {
        $this->payout = $event->payout;

        parent::__construct($id, $event);
    }

    /**
     * @param PayoutCreated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
