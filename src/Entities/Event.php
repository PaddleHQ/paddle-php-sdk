<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity as NotificationEntity;
use Paddle\SDK\Notifications\Notification\NotificationInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Event implements Entity
{
    protected function __construct(
        public readonly string $eventId,
        public readonly EventTypeName $eventType,
        public readonly \DateTimeInterface $occurredAt,
        public readonly NotificationEntity $data,
    ) {
    }

    private static function entityFrom(array $data): NotificationEntity
    {
        $type = explode('.', (string) $data['event_type']);
        $entity = $type[0] ?? 'Unknown';
        $identifier = str_replace('_', '', ucwords(implode('_', $type), '_'));

        /** @var class-string<NotificationEntity> $entity */
        $entity = sprintf('\Paddle\SDK\Notifications\Entities\%s', ucfirst($entity));

        if (! class_exists($entity) || ! in_array(NotificationEntity::class, class_implements($entity), true)) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $entity::from($data['data']);
    }

    public static function identifierFrom(array $data): string
    {
        $type = explode('.', (string) $data['event_type']);

        return str_replace('_', '', ucwords(implode('_', $type), '_'));
    }

    public static function from(array $data): self
    {
        $identifier = self::identifierFrom($data);

        /** @var class-string<Event> $event */
        $event = sprintf('\Paddle\SDK\Notifications\Events\%s', $identifier);

        if (! class_exists($event) || ! is_subclass_of($event, self::class)) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $event::fromEvent(
            $data['event_id'],
            EventTypeName::from($data['event_type']),
            DateTime::from($data['occurred_at']),
            self::entityFrom($data),
        );
    }

    public static function notificationFrom(array $data): Event&NotificationInterface
    {
        $identifier = self::identifierFrom($data);

        /** @var class-string<NotificationInterface> $notification */
        $notification = sprintf('\Paddle\SDK\Notifications\Notification\%sNotification', $identifier);

        if (
            ! class_exists($notification)
            || ! is_subclass_of($notification, self::class)
            || ! is_subclass_of($notification, NotificationInterface::class)
        ) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $notification::fromNotification(
            $data['event_id'],
            EventTypeName::from($data['event_type']),
            DateTime::from($data['occurred_at']),
            self::entityFrom($data),
            $data['notification_id'],
        );
    }

    public static function notificationFromRequest(ServerRequestInterface $request): Event&NotificationInterface
    {
        return self::notificationFrom(json_decode(
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
    ): self;
}
