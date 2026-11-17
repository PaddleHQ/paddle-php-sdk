<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Country\CountryTaxMode;
use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CountryCodeIso3;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CurrencyCodePayouts;

class Country implements Entity
{
    private function __construct(
        public CountryCode $iso,
        public CountryCodeIso3 $iso3,
        public string $name,
        public string $printableName,
        public bool $usesPostalCode,
        public CurrencyCode $transactionCurrency,
        public CurrencyCodePayouts $payoutCurrency,
        public bool $allowSales,
        public bool $hasRegions,
        public CountryTaxMode $taxMode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            iso: CountryCode::from($data['iso']),
            iso3: CountryCodeIso3::from($data['iso3']),
            name: $data['name'],
            printableName: $data['printable_name'],
            usesPostalCode: $data['uses_postal_code'],
            transactionCurrency: CurrencyCode::from($data['transaction_currency']),
            payoutCurrency: CurrencyCodePayouts::from($data['payout_currency']),
            allowSales: $data['allow_sales'],
            hasRegions: $data['has_regions'],
            taxMode: CountryTaxMode::from($data['tax_mode']),
        );
    }
}
