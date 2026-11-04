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
 * @method static SubscriptionHistoryPaymentAttemptedOperation SubscriptionUpdate()
 * @method static SubscriptionHistoryPaymentAttemptedOperation SubscriptionOneOffCharge()
 * @method static SubscriptionHistoryPaymentAttemptedOperation SubscriptionActivate()
 */
final class SubscriptionHistoryPaymentAttemptedOperation extends PaddleEnum
{
    private const SubscriptionUpdate = 'subscription_update';
    private const SubscriptionOneOffCharge = 'subscription_one_off_charge';
    private const SubscriptionActivate = 'subscription_activate';
}
