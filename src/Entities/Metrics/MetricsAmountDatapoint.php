<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsAmountDatapoint
{
    private function __construct(
        public string $timestamp,
        public string $amount,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            timestamp: $data['timestamp'],
            amount: $data['amount'],
        );
    }
}
