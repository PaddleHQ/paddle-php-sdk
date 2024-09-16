<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Address;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Events\AddressCreated;

final class AddressCreatedNotification extends AddressCreated implements NotificationInterface
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Address $address,
        public readonly string $notification_id,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $address);
    }

    public function getNotificationId(): string
    {
        return $this->notification_id;
    }

    /**
     * @param Address $data
     */
    public static function fromNotification(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Entity $data,
        string $notification_id,
    ): self {
        return new self($eventId, $eventType, $occurredAt, $data, $notification_id);
    }
}