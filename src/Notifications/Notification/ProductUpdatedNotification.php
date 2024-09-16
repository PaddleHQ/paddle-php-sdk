<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\Product;
use Paddle\SDK\Notifications\Events\ProductUpdated;

final class ProductUpdatedNotification extends ProductUpdated implements NotificationInterface
{
    private function __construct(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        Product $product,
        public readonly string $notification_id,
    ) {
        parent::__construct($eventId, $eventType, $occurredAt, $product);
    }

    public function getNotificationId(): string
    {
        return $this->notification_id;
    }

    /**
     * @param (Product) $data
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
