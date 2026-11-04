<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsExploreFields
{
    /**
     * @param array<MetricsExploreFieldDimension> $dimensions
     * @param array<MetricsExploreFieldMeasure>   $measures
     */
    private function __construct(
        public array $dimensions,
        public array $measures,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            dimensions: array_map(
                fn (array $dimension): MetricsExploreFieldDimension => MetricsExploreFieldDimension::from($dimension),
                $data['dimensions'],
            ),
            measures: array_map(
                fn (array $measure): MetricsExploreFieldMeasure => MetricsExploreFieldMeasure::from($measure),
                $data['measures'],
            ),
        );
    }
}
