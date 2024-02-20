<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\Entities\DateTime;

class AdjustmentTimePeriod
{
    private function __construct(
        public \DateTimeInterface $startsAt,
        public \DateTimeInterface $endsAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            startsAt: DateTime::from($data['starts_at']),
            endsAt: DateTime::from($data['ends_at']),
        );
    }
}
