<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class TimePeriod
{
    private function __construct(
        public Interval $interval,
        public int $frequency,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            Interval::from($data['interval']),
            $data['frequency'],
        );
    }
}
