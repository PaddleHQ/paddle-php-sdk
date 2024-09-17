<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity as NotificationEntity;
use Psr\Http\Message\ServerRequestInterface;

abstract class Event implements Entity
{
    protected function __construct(
        public string $eventId,
        public EventTypeName $eventType,
        public \DateTimeInterface $occurredAt,
        public NotificationEntity $data,
        public string|null $notificationId = null,
    ) {
    }

    public static function from(array $data): self
    {
        $type = explode('.', (string) $data['event_type']);
        $entity = $type[0] ?? 'Unknown';
        $identifier = str_replace('_', '', ucwords(implode('_', $type), '_'));

        /** @var class-string<Event> $event */
        $event = sprintf('\Paddle\SDK\Notifications\Events\%s', $identifier);

        if (! class_exists($event) || ! is_subclass_of($event, self::class)) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        /** @var class-string<NotificationEntity> $entity */
        $entity = sprintf('\Paddle\SDK\Notifications\Entities\%s', ucfirst($entity));

        if (! class_exists($entity) || ! in_array(NotificationEntity::class, class_implements($entity), true)) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $event::fromEvent(
            $data['event_id'],
            EventTypeName::from($data['event_type']),
            DateTime::from($data['occurred_at']),
            $entity::from($data['data']),
            $data['notification_id'] ?? null,
        );
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        return self::from(json_decode(
            (string) $request->getBody(),
            true,
            JSON_THROW_ON_ERROR,
        ));
    }

    abstract public static function fromEvent(
        string $eventId,
        EventTypeName $eventType,
        \DateTimeInterface $occurredAt,
        NotificationEntity $data,
        string|null $notificationId = null,
    ): static;
}
