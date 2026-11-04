<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Metrics\Operations\Explore;

use Paddle\SDK\Entities\Metrics\MetricsSortDirection;

class ExploreOrderBy implements \JsonSerializable
{
    public function __construct(
        public readonly string $field,
        public readonly MetricsSortDirection $dir,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'field' => $this->field,
            'dir' => $this->dir,
        ];
    }
}
