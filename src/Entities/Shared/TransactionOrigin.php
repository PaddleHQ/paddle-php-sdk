<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum TransactionOrigin: string
{
    case Api = 'api';
    case SubscriptionCharge = 'subscription_charge';
    case SubscriptionPaymentMethodChange = 'subscription_payment_method_change';
    case SubscriptionRecurring = 'subscription_recurring';
    case SubscriptionUpdate = 'subscription_update';
    case Web = 'web';
}
