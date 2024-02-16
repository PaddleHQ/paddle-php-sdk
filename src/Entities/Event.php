<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity as NotificationEntity;

class Event implements Entity
{
    /**
     * @internal
     */
    protected function __construct(
        public string $eventId,
        public EventTypeName $eventType,
        public \DateTimeInterface $occurredAt,
        public NotificationEntity $data,
    ) {
    }

    public static function from(array $data): self
    {
        $type = explode('.', (string) $data['event_type'])[0] ?? '';

        /** @var class-string<NotificationEntity> $entity */
        $entity = sprintf('\Paddle\SDK\Notifications\Entities\%s', ucfirst($type));

        if (! class_exists($entity) || ! in_array(NotificationEntity::class, class_implements($entity), true)) {
            throw new \UnexpectedValueException("Event type '{$type}' cannot be mapped to an object");
        }

        return new self(
            $data['event_id'],
            EventTypeName::from($data['event_type']),
            DateTime::from($data['occurred_at']),
            $entity::from($data['data']),
        );
    }
}
