<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionProrationBillingMode ProratedImmediately()
 * @method static SubscriptionProrationBillingMode ProratedNextBillingPeriod()
 * @method static SubscriptionProrationBillingMode FullImmediately()
 * @method static SubscriptionProrationBillingMode FullNextBillingPeriod()
 * @method static SubscriptionProrationBillingMode DoNotBill()
 */
final class SubscriptionProrationBillingMode extends PaddleEnum
{
    private const ProratedImmediately = 'prorated_immediately';
    private const ProratedNextBillingPeriod = 'prorated_next_billing_period';
    private const FullImmediately = 'full_immediately';
    private const FullNextBillingPeriod = 'full_next_billing_period';
    private const DoNotBill = 'do_not_bill';
}
