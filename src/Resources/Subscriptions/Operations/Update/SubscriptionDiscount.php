<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Subscriptions\Operations\Update;

use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;

class SubscriptionDiscount
{
    public function __construct(
        public string $id,
        public SubscriptionEffectiveFrom $effectiveFrom,
    ) {
    }
}
