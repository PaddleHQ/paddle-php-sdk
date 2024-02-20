<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

class SubscriptionUpdateItem
{
    private function __construct(
        public string $priceId,
        public int $quantity,
    ) {
    }
}
