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
 * @method static NotificationStatus NotAttempted()
 * @method static NotificationStatus NeedsRetry()
 * @method static NotificationStatus Delivered()
 * @method static NotificationStatus Failed()
 */
final class NotificationStatus extends PaddleEnum
{
    private const NotAttempted = 'not_attempted';
    private const NeedsRetry = 'needs_retry';
    private const Delivered = 'delivered';
    private const Failed = 'failed';
}
