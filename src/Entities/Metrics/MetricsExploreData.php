<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Entity;
use Paddle\SDK\Entities\Shared\CurrencyCode;

class MetricsExploreData implements Entity
{
    /**
     * @param array<MetricsExploreSeries> $series
     */
    private function __construct(
        public MetricEntity $entity,
        public MetricsBucketInterval $interval,
        public CurrencyCode|null $currencyCode,
        public \DateTimeInterface $startsAt,
        public \DateTimeInterface $endsAt,
        public \DateTimeInterface $updatedAt,
        public MetricsExploreFields $fields,
        public array $series,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entity: MetricEntity::from($data['entity']),
            interval: MetricsBucketInterval::from($data['interval']),
            currencyCode: isset($data['currency_code']) ? CurrencyCode::from($data['currency_code']) : null,
            startsAt: DateTime::from($data['starts_at']),
            endsAt: DateTime::from($data['ends_at']),
            updatedAt: DateTime::from($data['updated_at']),
            fields: MetricsExploreFields::from($data['fields']),
            series: array_map(
                fn (array $series): MetricsExploreSeries => MetricsExploreSeries::from($series),
                $data['series'],
            ),
        );
    }
}
