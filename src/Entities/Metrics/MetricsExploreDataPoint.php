<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

class MetricsExploreDataPoint
{
    /**
     * @param array<string, string> $measures
     */
    private function __construct(
        public string $timestamp,
        public array $measures,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            timestamp: $data['timestamp'],
            measures: $data['measures'],
        );
    }
}
