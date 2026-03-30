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

class MetricsMonthlyRecurringRevenue implements Entity
{
    /**
     * @param array<MetricsAmountDatapoint> $timeseries
     */
    private function __construct(
        public CurrencyCode $currencyCode,
        public array $timeseries,
        public \DateTimeInterface $startsAt,
        public \DateTimeInterface $endsAt,
        public MetricsInterval $interval,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            currencyCode: CurrencyCode::from($data['currency_code']),
            timeseries: array_map(
                fn (array $dp): MetricsAmountDatapoint => MetricsAmountDatapoint::from($dp),
                $data['timeseries'] ?? [],
            ),
            startsAt: DateTime::from($data['starts_at']),
            endsAt: DateTime::from($data['ends_at']),
            interval: MetricsInterval::from($data['interval']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
