<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static TransactionOrigin Api()
 * @method static TransactionOrigin SubscriptionCharge()
 * @method static TransactionOrigin SubscriptionPaymentMethodChange()
 * @method static TransactionOrigin SubscriptionRecurring()
 * @method static TransactionOrigin SubscriptionUpdate()
 * @method static TransactionOrigin Web()
 */
final class TransactionOrigin extends PaddleEnum
{
    private const Api = 'api';
    private const SubscriptionCharge = 'subscription_charge';
    private const SubscriptionPaymentMethodChange = 'subscription_payment_method_change';
    private const SubscriptionRecurring = 'subscription_recurring';
    private const SubscriptionUpdate = 'subscription_update';
    private const Web = 'web';
}
