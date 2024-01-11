<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class UnitPriceOverride
{
    /**
     * @param array<CountryCode> $countryCodes
     */
    public function __construct(
        public array $countryCodes,
        public Money $unitPrice,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['country_codes'], Money::from($data['unit_price']));
    }
}
