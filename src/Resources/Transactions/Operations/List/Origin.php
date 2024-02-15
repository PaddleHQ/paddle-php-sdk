<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\List;

use Paddle\SDK\PaddleEnum;

/**
 * @method static Origin Api()
 * @method static Origin SubscriptionCharge()
 * @method static Origin SubscriptionPaymentMethodChange()
 * @method static Origin SubscriptionRecurring()
 * @method static Origin SubscriptionUpdate()
 * @method static Origin Web()
 */
class Origin extends PaddleEnum
{
    private const Api = 'api';
    private const SubscriptionCharge = 'subscription_charge';
    private const SubscriptionPaymentMethodChange = 'subscription_payment_method_change';
    private const SubscriptionRecurring = 'subscription_recurring';
    private const SubscriptionUpdate = 'subscription_update';
    private const Web = 'web';
}
