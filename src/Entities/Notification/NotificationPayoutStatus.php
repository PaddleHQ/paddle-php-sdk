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
 * @method static NotificationPayoutStatus Unpaid()
 * @method static NotificationPayoutStatus Paid()
 */
final class NotificationPayoutStatus extends PaddleEnum
{
    private const Unpaid = 'unpaid';
    private const Paid = 'paid';
}
