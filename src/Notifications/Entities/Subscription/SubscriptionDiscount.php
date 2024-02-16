<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Subscription;

use Paddle\SDK\Notifications\Entities\DateTime;

class SubscriptionDiscount
{
    private function __construct(
        public string $id,
        public \DateTimeInterface $startsAt,
        public \DateTimeInterface|null $endsAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            DateTime::from($data['starts_at']),
            isset($data['ends_at']) ? DateTime::from($data['ends_at']) : null,
        );
    }
}
