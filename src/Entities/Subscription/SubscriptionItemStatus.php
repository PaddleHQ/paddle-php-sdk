<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

enum SubscriptionItemStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Trialing = 'trialing';
}
