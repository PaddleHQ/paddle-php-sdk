<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\Notification\NotificationOrigin;
use Paddle\SDK\Entities\Notification\NotificationStatus;

class Notification implements Entity
{
    private function __construct(
        public string $id,
        public EventTypeName $type,
        public NotificationStatus $status,
        public Event $payload,
        public \DateTimeInterface $occurredAt,
        public \DateTimeInterface|null $deliveredAt,
        public \DateTimeInterface|null $replayedAt,
        public NotificationOrigin $origin,
        public \DateTimeInterface|null $lastAttemptAt,
        public \DateTimeInterface|null $retryAt,
        public int $timesAttempted,
        public string $notificationSettingId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            EventTypeName::from($data['type']),
            NotificationStatus::from($data['status']),
            Event::from($data['payload']),
            DateTime::from($data['occurred_at']),
            isset($data['delivered_at']) ? DateTime::from($data['delivered_at']) : null,
            isset($data['replayed_at']) ? DateTime::from($data['replayed_at']) : null,
            NotificationOrigin::from($data['origin']),
            isset($data['last_attempt_at']) ? DateTime::from($data['last_attempt_at']) : null,
            isset($data['retry_at']) ? DateTime::from($data['retry_at']) : null,
            $data['times_attempted'],
            $data['notification_setting_id'],
        );
    }
}
