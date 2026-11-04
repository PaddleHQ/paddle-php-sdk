<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsExploreFieldDimension
{
    private function __construct(
        public string $name,
        public MetricsFieldType $type,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            type: MetricsFieldType::from($data['type']),
        );
    }
}
