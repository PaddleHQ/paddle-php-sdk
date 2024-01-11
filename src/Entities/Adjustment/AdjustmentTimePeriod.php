<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Adjustment;

class AdjustmentTimePeriod
{
    public function __construct(
        public \DateTimeInterface $startsAt,
        public \DateTimeInterface $endsAt,
    ) {
    }
}
