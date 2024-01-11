<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class TransactionPayoutTotals
{
    public function __construct(
        public string $subtotal,
        public string $discount,
        public string $tax,
        public string $total,
        public string $credit,
        public string $balance,
        public string $grandTotal,
        public string $fee,
        public string $earnings,
        public CurrencyCodePayouts $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['subtotal'],
            $data['discount'],
            $data['tax'],
            $data['total'],
            $data['credit'],
            $data['balance'],
            $data['grand_total'],
            $data['fee'] ?? null,
            $data['earnings'] ?? null,
            CurrencyCodePayouts::from($data['currency_code']),
        );
    }
}
