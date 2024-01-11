<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

enum SubscriptionOnPaymentFailure: string
{
    case PreventChange = 'prevent_change';
    case ApplyChange = 'apply_change';
}
