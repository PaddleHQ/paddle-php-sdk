<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricEntityDimension
{
    /**
     * @param array<MetricsFilterOperator> $filterOps
     */
    private function __construct(
        public string $name,
        public MetricsFieldType $type,
        public array $filterOps,
        public bool $multiValued,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            type: MetricsFieldType::from($data['type']),
            filterOps: array_map(
                fn (string $op): MetricsFilterOperator => MetricsFilterOperator::from($op),
                $data['filter_ops'],
            ),
            multiValued: $data['multi_valued'] ?? false,
        );
    }
}
