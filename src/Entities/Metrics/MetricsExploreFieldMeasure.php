<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsExploreFieldMeasure
{
    private function __construct(
        public string $name,
        public MetricsFieldType $type,
        public string|null $field,
        public MetricsAggregation|null $agg,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            type: MetricsFieldType::from($data['type']),
            field: $data['field'] ?? null,
            agg: isset($data['agg']) ? MetricsAggregation::from($data['agg']) : null,
        );
    }
}
