<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Notifications\Entities\Entity;
use Psr\Http\Message\ServerRequestInterface;

abstract class Notification implements Entity
{
    public readonly string $eventId;
    public readonly EventTypeName $eventType;
    public readonly \DateTimeInterface $occurredAt;

    protected function __construct(
        public readonly string $id,
        Event $event,
    ) {
        $this->eventId = $event->eventId;
        $this->eventType = $event->eventType;
        $this->occurredAt = $event->occurredAt;
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        return self::from(json_decode(
            (string) $request->getBody(),
            true,
            JSON_THROW_ON_ERROR,
        ));
    }

    public static function from(array $data): self
    {
        $type = explode('.', (string) $data['event_type']);
        $identifier = str_replace('_', '', ucwords(implode('_', $type), '_'));

        /** @var class-string<Notification> $notification */
        $notification = sprintf('\Paddle\SDK\Notifications\Notification\%sNotification', $identifier);

        if (! class_exists($notification) || ! is_subclass_of($notification, self::class)) {
            throw new \UnexpectedValueException("Notification type '{$identifier}' cannot be mapped to an object");
        }

        return $notification::fromEvent(
            $data['notification_id'],
            Event::from($data),
        );
    }

    abstract protected static function fromEvent(
        string $id,
        Event $event,
    ): static;
}
