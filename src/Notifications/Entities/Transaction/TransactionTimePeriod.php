<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Transaction;

use Paddle\SDK\Notifications\Entities\DateTime;

class TransactionTimePeriod
{
    private function __construct(
        public \DateTimeInterface|null $startsAt,
        public \DateTimeInterface|null $endsAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            DateTime::from($data['starts_at']),
            DateTime::from($data['ends_at']),
        );
    }
}
