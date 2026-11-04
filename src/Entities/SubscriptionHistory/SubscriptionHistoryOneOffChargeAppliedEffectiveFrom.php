<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionHistoryOneOffChargeAppliedEffectiveFrom Immediately()
 * @method static SubscriptionHistoryOneOffChargeAppliedEffectiveFrom NextBillingPeriod()
 */
final class SubscriptionHistoryOneOffChargeAppliedEffectiveFrom extends PaddleEnum
{
    private const Immediately = 'immediately';
    private const NextBillingPeriod = 'next_billing_period';
}
