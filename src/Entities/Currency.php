<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CurrencyCode;

class Currency implements Entity
{
    /**
     * @param array<CountryCode> $applicableCountries
     */
    private function __construct(
        public CurrencyCode $code,
        public string $name,
        public int $decimalPlaces,
        public bool $canBeBalance,
        public array $applicableCountries,
        public string $minimumPaymentAmount,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            code: CurrencyCode::from($data['code']),
            name: $data['name'],
            decimalPlaces: $data['decimal_places'],
            canBeBalance: $data['can_be_balance'],
            applicableCountries: array_map(
                fn (string $country): CountryCode => CountryCode::from($country),
                $data['applicable_countries'],
            ),
            minimumPaymentAmount: $data['minimum_payment_amount'],
        );
    }
}
