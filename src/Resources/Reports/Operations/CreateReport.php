<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Reports\Operations;

use Paddle\SDK\Entities\Report\ReportFilter;
use Paddle\SDK\Entities\Report\ReportType;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;

class CreateReport implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<ReportFilter> $filters
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        public readonly ReportType $type,
        public readonly array $filters = [],
    ) {
        if ($invalid = array_filter($this->filters, fn ($value): bool => ! $value instanceof ReportFilter)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('filters', ReportFilter::class, implode(', ', $invalid));
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
