<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

class SubscriptionItemsWithPrice
{
    public function __construct(
        public SubscriptionNonCatalogPrice|SubscriptionNonCatalogPriceWithProduct $price,
        public int $quantity,
    ) {
    }
}
