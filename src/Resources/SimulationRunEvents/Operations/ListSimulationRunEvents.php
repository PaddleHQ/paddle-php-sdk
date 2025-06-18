<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\SimulationRunEvents\Operations;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListSimulationRunEvents implements HasParameters
{
    /**
     * @param array<string> $ids
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $ids = [],
    ) {
        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'id' => implode(',', $this->ids),
            ]),
        );
    }
}
