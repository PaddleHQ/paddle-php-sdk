<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Metrics\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Metrics\MetricEntity;
use Paddle\SDK\Entities\Metrics\MetricsBucketInterval;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreFilter;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreMeasure;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreOrderBy;
use Paddle\SDK\Undefined;

class ExploreMetrics implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param \DateTimeInterface|string       $from       an RFC 3339 datetime, a YYYY-MM-DD date string, or a \DateTimeInterface
     * @param \DateTimeInterface|string       $to         an RFC 3339 datetime, a YYYY-MM-DD date string, or a \DateTimeInterface
     * @param array<ExploreMeasure>           $measures
     * @param array<string>|Undefined         $dimensions
     * @param array<ExploreFilter>|Undefined  $filters
     * @param array<ExploreOrderBy>|Undefined $orderBy
     *
     * @throws InvalidArgumentException When measures, filters or orderBy contain invalid types
     */
    public function __construct(
        public readonly MetricEntity $entity,
        public readonly \DateTimeInterface|string $from,
        public readonly \DateTimeInterface|string $to,
        public readonly array $measures,
        public readonly MetricsBucketInterval|Undefined $interval = new Undefined(),
        public readonly array|Undefined $dimensions = new Undefined(),
        public readonly array|Undefined $filters = new Undefined(),
        public readonly array|Undefined $orderBy = new Undefined(),
        public readonly int|Undefined $perPage = new Undefined(),
    ) {
        if ($invalid = array_filter($this->measures, fn ($value): bool => ! $value instanceof ExploreMeasure)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('measures', ExploreMeasure::class, implode(', ', array_map('get_debug_type', $invalid)));
        }

        if (is_array($this->filters) && $invalid = array_filter($this->filters, fn ($value): bool => ! $value instanceof ExploreFilter)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('filters', ExploreFilter::class, implode(', ', array_map('get_debug_type', $invalid)));
        }

        if (is_array($this->orderBy) && $invalid = array_filter($this->orderBy, fn ($value): bool => ! $value instanceof ExploreOrderBy)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('orderBy', ExploreOrderBy::class, implode(', ', array_map('get_debug_type', $invalid)));
        }
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'entity' => $this->entity,
            'from' => self::formatBoundary($this->from),
            'to' => self::formatBoundary($this->to),
            'measures' => $this->measures,
            'interval' => $this->interval,
            'dimensions' => $this->dimensions,
            'filters' => $this->filters,
            'order_by' => $this->orderBy,
            'per_page' => $this->perPage,
        ]);
    }

    private static function formatBoundary(\DateTimeInterface|string $value): string
    {
        return is_string($value) ? $value : $value->format(DateTime::PADDLE_RFC3339);
    }
}
