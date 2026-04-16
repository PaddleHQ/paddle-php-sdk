<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Charge;

class SubscriptionChargeItem
{
    public function __construct(
        public string $priceId,
        public int $quantity,
    ) {
    }
}
