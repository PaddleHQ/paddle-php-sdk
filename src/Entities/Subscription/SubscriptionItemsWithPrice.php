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
 * @deprecated use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionUpdateItemWithPrice for update and preview update operations
 */
class SubscriptionItemsWithPrice
{
    public function __construct(
        public SubscriptionNonCatalogPrice|SubscriptionNonCatalogPriceWithProduct $price,
        public int $quantity,
    ) {
    }
}
