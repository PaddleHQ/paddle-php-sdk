<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class TransactionDetailsPreview
{
    /**
     * @param array<TaxRatesUsed>               $taxRatesUsed
     * @param array<TransactionLineItemPreview> $lineItems
     */
    private function __construct(
        public array $taxRatesUsed,
        public TransactionTotals $totals,
        public array $lineItems,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            taxRatesUsed: array_map(fn (array $rate): TaxRatesUsed => TaxRatesUsed::from($rate), $data['tax_rates_used']),
            totals: TransactionTotals::from($data['totals']),
            lineItems: array_map(fn (array $item): TransactionLineItemPreview => TransactionLineItemPreview::from($item), $data['line_items']),
        );
    }
}
