<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

/**
 * @deprecated use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionUpdateItem for update and preview update operations
 */
class SubscriptionItems
{
    public function __construct(
        public string $priceId,
        public int $quantity,
    ) {
    }
}
