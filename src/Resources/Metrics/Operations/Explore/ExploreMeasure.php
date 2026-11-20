<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Metrics\Operations\Explore;

use Paddle\SDK\Entities\Metrics\MetricsAggregation;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class ExploreMeasure implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string $field,
        public readonly MetricsAggregation|Undefined|null $agg = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'field' => $this->field,
            'agg' => $this->agg,
        ]);
    }
}
