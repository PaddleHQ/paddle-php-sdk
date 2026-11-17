<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricEntityMeasure
{
    /**
     * @param array<MetricsAggregation>|null $aggs
     */
    private function __construct(
        public string $name,
        public MetricsFieldType $type,
        public array|null $aggs,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            type: MetricsFieldType::from($data['type']),
            aggs: isset($data['aggs'])
                ? array_map(fn (string $agg): MetricsAggregation => MetricsAggregation::from($agg), $data['aggs'])
                : null,
        );
    }
}
