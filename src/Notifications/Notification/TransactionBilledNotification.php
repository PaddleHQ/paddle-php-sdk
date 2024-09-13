<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Transaction;
use Paddle\SDK\Notifications\Events\TransactionBilled;
use Paddle\SDK\Notifications\Notification;

final class TransactionBilledNotification extends Notification
{
    public readonly Transaction $transaction;

    private function __construct(string $id, TransactionBilled $event)
    {
        $this->transaction = $event->transaction;

        parent::__construct($id, $event);
    }

    /**
     * @param TransactionBilled $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
