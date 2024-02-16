<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class AdjustmentProration
{
    private function __construct(
        public string $rate,
        public AdjustmentTimePeriod $billingPeriod,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            rate: $data['rate'],
            billingPeriod: AdjustmentTimePeriod::from($data['billing_period']),
        );
    }
}
