<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class AdjustmentTotals
{
    private function __construct(
        public string $subtotal,
        public string $tax,
        public string $total,
        public string $fee,
        public string $earnings,
        public CurrencyCode $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            subtotal: $data['subtotal'],
            tax: $data['tax'],
            total: $data['total'],
            fee: $data['fee'],
            earnings: $data['earnings'],
            currencyCode: CurrencyCode::from($data['currency_code']),
        );
    }
}
