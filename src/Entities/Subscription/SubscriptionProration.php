<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

class SubscriptionProration
{
    private function __construct(
        public string $rate,
        public SubscriptionTimePeriod $billingPeriod,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['rate'], SubscriptionTimePeriod::from($data['billing_period']));
    }
}
