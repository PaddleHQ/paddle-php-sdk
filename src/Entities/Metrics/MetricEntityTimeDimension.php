<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricEntityTimeDimension
{
    /**
     * @param array<MetricsBucketInterval> $intervals
     */
    private function __construct(
        public array $intervals,
        public int $maxLookbackDays,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            intervals: array_map(
                fn (string $interval): MetricsBucketInterval => MetricsBucketInterval::from($interval),
                $data['intervals'],
            ),
            maxLookbackDays: $data['max_lookback_days'],
        );
    }
}
