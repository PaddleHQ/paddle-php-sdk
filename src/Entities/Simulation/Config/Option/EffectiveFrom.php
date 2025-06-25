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
 * @method static EffectiveFrom NextBillingPeriod()
 * @method static EffectiveFrom Immediately()
 */
final class EffectiveFrom extends PaddleEnum
{
    private const NextBillingPeriod = 'next_billing_period';
    private const Immediately = 'immediately';
}
