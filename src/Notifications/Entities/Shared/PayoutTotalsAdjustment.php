<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class PayoutTotalsAdjustment
{
    private function __construct(
        public string $subtotal,
        public string $tax,
        public string $total,
        public string $fee,
        public ChargebackFee|null $chargebackFee,
        public string $earnings,
        public CurrencyCodePayouts $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            subtotal: $data['subtotal'],
            tax: $data['tax'],
            total: $data['total'],
            fee: $data['fee'],
            chargebackFee: isset($data['chargeback_fee']) ? ChargebackFee::from($data['chargeback_fee']) : null,
            earnings: $data['earnings'],
            currencyCode: CurrencyCodePayouts::from($data['currency_code']),
        );
    }
}
