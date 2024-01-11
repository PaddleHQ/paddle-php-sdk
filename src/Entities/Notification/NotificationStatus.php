<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Notification;

enum NotificationStatus: string
{
    case NotAttempted = 'not_attempted';
    case NeedsRetry = 'needs_retry';
    case Delivered = 'delivered';
    case Failed = 'failed';
}
