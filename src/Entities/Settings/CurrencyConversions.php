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

class CurrencyConversions implements Entity
{
    /**
     * @param array<string, CurrencyConversion> $conversions keyed by three-letter ISO 4217 currency code
     */
    private function __construct(
        public array $conversions,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            conversions: array_map(
                fn (array $conversion): CurrencyConversion => CurrencyConversion::from($conversion),
                $data,
            ),
        );
    }
}
