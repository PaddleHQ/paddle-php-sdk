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

class MetricsRevenueDatapoint
{
    private function __construct(
        public \DateTimeInterface $timestamp,
        public string $amount,
        public int $count,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            timestamp: DateTime::from($data['timestamp']),
            amount: $data['amount'],
            count: $data['count'],
        );
    }
}
