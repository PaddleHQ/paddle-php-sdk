<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Notification;

use Paddle\SDK\PaddleEnum;

/**
 * @method static NotificationOrigin Event()
 * @method static NotificationOrigin Replay()
 */
final class NotificationOrigin extends PaddleEnum
{
    private const Event = 'event';
    private const Replay = 'replay';
}
