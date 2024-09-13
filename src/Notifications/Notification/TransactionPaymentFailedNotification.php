<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Transaction;
use Paddle\SDK\Notifications\Events\TransactionPaymentFailed;
use Paddle\SDK\Notifications\Notification;

final class TransactionPaymentFailedNotification extends Notification
{
    public readonly Transaction $transaction;

    private function __construct(string $id, TransactionPaymentFailed $event)
    {
        $this->transaction = $event->transaction;

        parent::__construct($id, $event);
    }

    /**
     * @param TransactionPaymentFailed $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
