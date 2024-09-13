<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Address;
use Paddle\SDK\Notifications\Events\AddressCreated;
use Paddle\SDK\Notifications\Notification;

final class AddressCreatedNotification extends Notification
{
    public readonly Address $address;

    private function __construct(string $id, AddressCreated $event)
    {
        $this->address = $event->address;

        parent::__construct($id, $event);
    }

    /**
     * @param AddressCreated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
