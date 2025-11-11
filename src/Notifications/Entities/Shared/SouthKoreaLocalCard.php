<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class SouthKoreaLocalCard
{
    private function __construct(
        public SouthKoreaLocalCardType $type,
        public string $last4,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            type: SouthKoreaLocalCardType::from($data['type']),
            last4: $data['last4'],
        );
    }
}
