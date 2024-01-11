<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\NotificationSetting;

enum NotificationSettingType: string
{
    case Email = 'email';
    case Url = 'url';
}
