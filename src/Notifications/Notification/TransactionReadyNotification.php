<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Transaction;
use Paddle\SDK\Notifications\Events\TransactionReady;
use Paddle\SDK\Notifications\Notification;

final class TransactionReadyNotification extends Notification
{
    public readonly Transaction $transaction;

    private function __construct(string $id, TransactionReady $event)
    {
        $this->transaction = $event->transaction;

        parent::__construct($id, $event);
    }

    /**
     * @param TransactionReady $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
