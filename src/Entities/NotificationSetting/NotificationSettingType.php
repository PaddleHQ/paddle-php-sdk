<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\NotificationSetting;

use Paddle\SDK\PaddleEnum;

/**
 * @method static NotificationSettingType Email()
 * @method static NotificationSettingType Url()
 */
final class NotificationSettingType extends PaddleEnum
{
    private const Email = 'email';
    private const Url = 'url';
}
