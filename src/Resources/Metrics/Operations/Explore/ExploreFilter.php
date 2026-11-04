<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Metrics\Operations\Explore;

use Paddle\SDK\Entities\Metrics\MetricsFilterOperator;

class ExploreFilter implements \JsonSerializable
{
    /**
     * @param array<string> $value
     */
    public function __construct(
        public readonly string $field,
        public readonly MetricsFilterOperator $op,
        public readonly array $value,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'field' => $this->field,
            'op' => $this->op,
            'value' => $this->value,
        ];
    }
}
