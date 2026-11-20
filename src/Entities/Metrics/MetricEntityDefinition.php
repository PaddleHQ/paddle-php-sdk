<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

use Paddle\SDK\Entities\Entity;

class MetricEntityDefinition implements Entity
{
    /**
     * @param array<MetricEntityDimension> $dimensions
     * @param array<MetricEntityMeasure>   $measures
     */
    private function __construct(
        public MetricEntity $entity,
        public MetricEntityTimeDimension $timeDimension,
        public array $dimensions,
        public array $measures,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entity: MetricEntity::from($data['entity']),
            timeDimension: MetricEntityTimeDimension::from($data['time_dimension']),
            dimensions: array_map(
                fn (array $dimension): MetricEntityDimension => MetricEntityDimension::from($dimension),
                $data['dimensions'],
            ),
            measures: array_map(
                fn (array $measure): MetricEntityMeasure => MetricEntityMeasure::from($measure),
                $data['measures'],
            ),
        );
    }
}
