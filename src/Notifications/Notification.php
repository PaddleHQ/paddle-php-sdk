<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Entity;
use Psr\Http\Message\ServerRequestInterface;

class Notification implements Entity
{
    private function __construct(
        public readonly string $id,
        public readonly Event $event,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['notification_id'],
            Event::from($data),
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
}
