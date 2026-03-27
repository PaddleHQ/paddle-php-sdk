<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsCheckoutConversionDatapoint
{
    private function __construct(
        public string $timestamp,
        public int $count,
        public int $completedCount,
        public string $rate,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            timestamp: $data['timestamp'],
            count: $data['count'],
            completedCount: $data['completed_count'],
            rate: $data['rate'],
        );
    }
}
