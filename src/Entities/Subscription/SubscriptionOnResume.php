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
 * @method static SubscriptionOnResume ContinueExistingBillingPeriod()
 * @method static SubscriptionOnResume StartNewBillingPeriod()
 */
final class SubscriptionOnResume extends PaddleEnum
{
    private const ContinueExistingBillingPeriod = 'continue_existing_billing_period';
    private const StartNewBillingPeriod = 'start_new_billing_period';
}
