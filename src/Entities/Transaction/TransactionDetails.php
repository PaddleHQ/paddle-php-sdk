<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\Shared\TaxRatesUsed;
use Paddle\SDK\Entities\Shared\TransactionPayoutTotals;
use Paddle\SDK\Entities\Shared\TransactionPayoutTotalsAdjusted;
use Paddle\SDK\Entities\Shared\TransactionTotals;
use Paddle\SDK\Entities\Shared\TransactionTotalsAdjusted;

class TransactionDetails
{
    /**
     * @param array<TaxRatesUsed>        $taxRatesUsed
     * @param array<TransactionLineItem> $lineItems
     */
    private function __construct(
        public array $taxRatesUsed,
        public TransactionTotals $totals,
        public TransactionTotalsAdjusted|null $adjustedTotals,
        public TransactionPayoutTotals|null $payoutTotals,
        public TransactionPayoutTotalsAdjusted|null $adjustedPayoutTotals,
        public array $lineItems,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            array_map(fn (array $taxRateUsed): TaxRatesUsed => TaxRatesUsed::from($taxRateUsed), $data['tax_rates_used']),
            TransactionTotals::from($data['totals']),
            isset($data['adjusted_totals']) ? TransactionTotalsAdjusted::from($data['adjusted_totals']) : null,
            isset($data['payout_totals']) ? TransactionPayoutTotals::from($data['payout_totals']) : null,
            isset($data['adjusted_payout_totals']) ? TransactionPayoutTotalsAdjusted::from($data['adjusted_payout_totals']) : null,
            array_map(fn (array $lineItem): TransactionLineItem => TransactionLineItem::from($lineItem), $data['line_items']),
        );
    }
}
