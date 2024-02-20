<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class TransactionTotalsAdjusted
{
    private function __construct(
        public string $subtotal,
        public string $tax,
        public string $total,
        public string $grandTotal,
        public string|null $fee,
        public string|null $earnings,
        public CurrencyCode $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['subtotal'],
            $data['tax'],
            $data['total'],
            $data['grand_total'],
            $data['fee'] ?? null,
            $data['earnings'] ?? null,
            CurrencyCode::from($data['currency_code']),
        );
    }
}
