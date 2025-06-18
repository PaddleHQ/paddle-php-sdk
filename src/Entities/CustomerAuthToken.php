<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Entity;

class CustomerAuthToken implements Entity
{
    private function __construct(
        public string $customerAuthToken,
        public \DateTimeInterface $expiresAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            customerAuthToken: $data['customer_auth_token'],
            expiresAt: DateTime::from($data['expires_at']),
        );
    }
}
