<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class PayoutTotalsAdjustment implements \JsonSerializable
{
    use FiltersUndefined;

    private function __construct(
        public string $subtotal,
        public string $tax,
        public string $total,
        public string $fee,
        public ChargebackFee|Undefined|null $chargebackFee,
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
            chargebackFee: isset($data['chargeback_fee']) ? ChargebackFee::from($data['chargeback_fee']) : new Undefined(),
            earnings: $data['earnings'],
            currencyCode: CurrencyCodePayouts::from($data['currency_code']),
        );
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
            'fee' => $this->fee,
            'chargeback_fee' => $this->chargebackFee,
            'earnings' => $this->earnings,
            'currency_code' => $this->currencyCode,
        ]);
    }
}
