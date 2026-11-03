<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\Entities\Entity;

class BalanceCurrency implements Entity
{
    /**
     * @param array<BalanceCurrencyCode> $enabled
     */
    private function __construct(
        public BalanceCurrencyCode $primary,
        public BalanceCurrencyCode $preferred,
        public array $enabled,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            primary: BalanceCurrencyCode::from($data['primary']),
            preferred: BalanceCurrencyCode::from($data['preferred']),
            enabled: array_map(
                fn (string $currency): BalanceCurrencyCode => BalanceCurrencyCode::from($currency),
                $data['enabled'],
            ),
        );
    }
}
