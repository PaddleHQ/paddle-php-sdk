<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Customer;
use Paddle\SDK\Notifications\Events\CustomerUpdated;
use Paddle\SDK\Notifications\Notification;

final class CustomerUpdatedNotification extends Notification
{
    public readonly Customer $customer;

    private function __construct(string $id, CustomerUpdated $event)
    {
        $this->customer = $event->customer;

        parent::__construct($id, $event);
    }

    /**
     * @param CustomerUpdated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
