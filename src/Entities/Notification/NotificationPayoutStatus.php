<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Notification;

enum NotificationPayoutStatus: string
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
}
