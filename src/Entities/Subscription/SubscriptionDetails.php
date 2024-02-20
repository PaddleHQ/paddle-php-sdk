<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Shared\TaxRatesUsed;
use Paddle\SDK\Entities\Shared\TransactionPayoutTotals;
use Paddle\SDK\Entities\Shared\TransactionPayoutTotalsAdjusted;
use Paddle\SDK\Entities\Shared\TransactionTotals;
use Paddle\SDK\Entities\Shared\TransactionTotalsAdjusted;

class SubscriptionDetails
{
    /**
     * @param array<TaxRatesUsed>                    $taxRatesUsed
     * @param array<SubscriptionTransactionLineItem> $lineItems
     */
    private function __construct(
        public array $taxRatesUsed,
        public TransactionTotals $totals,
        public TransactionTotalsAdjusted $adjustedTotals,
        public TransactionPayoutTotals $payoutTotals,
        public TransactionPayoutTotalsAdjusted $adjustedPayoutTotals,
        public array $lineItems,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            array_map(fn (array $taxRate): TaxRatesUsed => TaxRatesUsed::from($taxRate), $data['tax_rate_used'] ?? []),
            TransactionTotals::from($data['transaction_totals']),
            TransactionTotalsAdjusted::from($data['transaction_totals_adjusted']),
            TransactionPayoutTotals::from($data['transaction_payout_totals']),
            TransactionPayoutTotalsAdjusted::from($data['transaction_payout_totals_adjusted']),
            array_map(fn (array $item): SubscriptionTransactionLineItem => SubscriptionTransactionLineItem::from($item), $data['line_items'] ?? []),
        );
    }
}
