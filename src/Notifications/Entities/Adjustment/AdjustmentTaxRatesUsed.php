<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Adjustment;

class AdjustmentTaxRatesUsed
{
    private function __construct(
        public string $taxRate,
        public AdjustmentTaxRatesUsedTotals $totals,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['tax_rate'],
            AdjustmentTaxRatesUsedTotals::from($data['totals']),
        );
    }
}
