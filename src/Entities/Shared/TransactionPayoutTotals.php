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
    private function __construct(
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
        public string $creditToBalance,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            subtotal: $data['subtotal'],
            discount: $data['discount'],
            tax: $data['tax'],
            total: $data['total'],
            credit: $data['credit'],
            balance: $data['balance'],
            grandTotal: $data['grand_total'],
            fee: $data['fee'] ?? null,
            earnings: $data['earnings'] ?? null,
            currencyCode: CurrencyCodePayouts::from($data['currency_code']),
            creditToBalance: $data['credit_to_balance'],
        );
    }
}
