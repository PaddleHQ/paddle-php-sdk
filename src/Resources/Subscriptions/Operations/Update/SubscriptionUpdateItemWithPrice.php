<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Update;

use Paddle\SDK\Resources\Subscriptions\Operations\Price\SubscriptionNonCatalogPrice;
use Paddle\SDK\Resources\Subscriptions\Operations\Price\SubscriptionNonCatalogPriceWithProduct;

class SubscriptionUpdateItemWithPrice
{
    public function __construct(
        public SubscriptionNonCatalogPrice|SubscriptionNonCatalogPriceWithProduct $price,
        public int $quantity,
    ) {
    }
}
