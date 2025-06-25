<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Simulation\Config\Option;

use Paddle\SDK\PaddleEnum;

/**
 * @method static DunningExhaustedAction SubscriptionPaused()
 * @method static DunningExhaustedAction SubscriptionCanceled()
 */
final class DunningExhaustedAction extends PaddleEnum
{
    private const SubscriptionPaused = 'subscription_paused';
    private const SubscriptionCanceled = 'subscription_canceled';
}
