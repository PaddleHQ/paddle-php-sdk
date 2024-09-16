<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Discount;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Events\DiscountCreated;

final class DiscountCreatedNotification extends DiscountCreated implements NotificationInterface
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Discount $discount,
        public readonly string $notification_id,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $discount);
    }

    public function getNotificationId(): string
    {
        return $this->notification_id;
    }

    /**
     * @param (Discount) $data
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