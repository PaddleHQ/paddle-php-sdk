<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Notification;

enum NotificationOrigin: string
{
    case Event = 'event';
    case Replay = 'replay';
}
