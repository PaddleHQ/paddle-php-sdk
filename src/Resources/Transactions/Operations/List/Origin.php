<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\List;

enum Origin: string
{
    case Api = 'api';
    case SubscriptionCharge = 'subscription_charge';
    case SubscriptionPaymentMethodChange = 'subscription_payment_method_change';
    case SubscriptionRecurring = 'subscription_recurring';
    case SubscriptionUpdate = 'subscription_update';
    case Web = 'web';
}
