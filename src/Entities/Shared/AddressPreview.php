<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class AddressPreview
{
    public function __construct(
        public string|null $postalCode,
        public CountryCode $countryCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['postal_code'] ?? null,
            CountryCode::from($data['country_code']),
        );
    }
}
