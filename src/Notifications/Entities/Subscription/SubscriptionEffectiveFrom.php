<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Subscription;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionEffectiveFrom NextBillingPeriod()
 * @method static SubscriptionEffectiveFrom Immediately()
 */
final class SubscriptionEffectiveFrom extends PaddleEnum
{
    private const NextBillingPeriod = 'next_billing_period';
    private const Immediately = 'immediately';
}
