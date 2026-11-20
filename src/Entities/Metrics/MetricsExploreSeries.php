<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsExploreSeries
{
    /**
     * @param array<string, string>          $dimensions
     * @param array<MetricsExploreDataPoint> $timeseries
     */
    private function __construct(
        public array $dimensions,
        public array $timeseries,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            dimensions: $data['dimensions'],
            timeseries: array_map(
                fn (array $point): MetricsExploreDataPoint => MetricsExploreDataPoint::from($point),
                $data['timeseries'],
            ),
        );
    }
}
