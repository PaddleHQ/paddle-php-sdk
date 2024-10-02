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
 * @method static NotificationSettingTrafficSource All()
 * @method static NotificationSettingTrafficSource Platform()
 * @method static NotificationSettingTrafficSource Simulation()
 */
final class NotificationSettingTrafficSource extends PaddleEnum
{
    private const All = 'all';
    private const Platform = 'platform';
    private const Simulation = 'simulation';
}
