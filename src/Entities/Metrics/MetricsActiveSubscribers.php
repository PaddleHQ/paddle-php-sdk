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

class MetricsActiveSubscribers implements Entity
{
    /**
     * @param array<MetricsCountDatapoint> $timeseries
     */
    private function __construct(
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
            timeseries: array_map(
                fn (array $dp): MetricsCountDatapoint => MetricsCountDatapoint::from($dp),
                $data['timeseries'] ?? [],
            ),
            startsAt: DateTime::from($data['starts_at']),
            endsAt: DateTime::from($data['ends_at']),
            interval: MetricsInterval::from($data['interval']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
