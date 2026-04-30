<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Charge;

class SubscriptionChargeItemWithPrice
{
    public function __construct(
        public SubscriptionChargeNonCatalogPrice|SubscriptionChargeNonCatalogPriceWithProduct $price,
        public int $quantity,
    ) {
    }
}
