<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Update;

use Paddle\SDK\Undefined;

class SubscriptionUpdateItem
{
    public function __construct(
        public string $priceId,
        public int|Undefined $quantity = new Undefined(),
    ) {
    }
}
