<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class TransactionPayoutTotalsAdjusted
{
    private function __construct(
        public string $subtotal,
        public string $tax,
        public string $total,
        public string $fee,
        public ChargebackFee $chargebackFee,
        public string|null $retainedFee,
        public string $earnings,
        public CurrencyCodePayouts $currencyCode,
        public string|null $exchangeRate,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['subtotal'],
            $data['tax'],
            $data['total'],
            $data['fee'],
            ChargebackFee::from($data['chargeback_fee']),
            $data['retained_fee'] ?? null,
            $data['earnings'],
            CurrencyCodePayouts::from($data['currency_code']),
            $data['exchange_rate'] ?? null,
        );
    }
}
