<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Customer;
use Paddle\SDK\Notifications\Events\CustomerCreated;
use Paddle\SDK\Notifications\Notification;

final class CustomerCreatedNotification extends Notification
{
    public readonly Customer $customer;

    private function __construct(string $id, CustomerCreated $event)
    {
        $this->customer = $event->customer;

        parent::__construct($id, $event);
    }

    /**
     * @param CustomerCreated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
