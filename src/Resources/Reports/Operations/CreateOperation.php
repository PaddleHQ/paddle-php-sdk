<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Reports\Operations;

use Paddle\SDK\Entities\Report\ReportFilters;
use Paddle\SDK\Entities\Report\ReportType;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;

class CreateOperation implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<ReportFilters> $filters
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        public readonly ReportType $type,
        public readonly array $filters = [],
    ) {
        if ($invalid = array_filter($this->filters, fn ($value): bool => ! $value instanceof ReportFilters)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('filters', ReportFilters::class, implode(', ', $invalid));
        }
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined(array_filter([
            'type' => $this->type,
            'filters' => $this->filters,
        ]));
    }
}
