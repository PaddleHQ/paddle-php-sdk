<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class TransactionPayoutTotals
{
    private function __construct(
        public string $subtotal,
        public string|null $discount,
        public string $tax,
        public string $total,
        public string|null $credit,
        public string|null $balance,
        public string|null $grandTotal,
        public string $fee,
        public string $earnings,
        public CurrencyCodePayouts $currencyCode,
        public string|null $creditToBalance,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            subtotal: $data['subtotal'],
            discount: $data['discount'] ?? null,
            tax: $data['tax'],
            total: $data['total'],
            credit: $data['credit'] ?? null,
            balance: $data['balance'] ?? null,
            grandTotal: $data['grand_total'] ?? null,
            fee: $data['fee'] ?? null,
            earnings: $data['earnings'] ?? null,
            currencyCode: CurrencyCodePayouts::from($data['currency_code']),
            creditToBalance: $data['credit_to_balance'] ?? null,
        );
    }
}
