<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Adjustment\AdjustmentItem;
use Paddle\SDK\Notifications\Entities\Adjustment\AdjustmentTaxRatesUsed;
use Paddle\SDK\Notifications\Entities\Adjustment\AdjustmentType;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\Action;
use Paddle\SDK\Notifications\Entities\Shared\AdjustmentStatus;
use Paddle\SDK\Notifications\Entities\Shared\AdjustmentTotals;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\PayoutTotalsAdjustment;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Adjustment implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    /**
     * @param array<AdjustmentItem>         $items
     * @param array<AdjustmentTaxRatesUsed> $taxRatesUsed
     */
    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly Action|Undefined $action = new Undefined(),
        public readonly string|Undefined $transactionId = new Undefined(),
        public readonly string|Undefined|null $subscriptionId = new Undefined(),
        public readonly string|Undefined $customerId = new Undefined(),
        public readonly string|Undefined $reason = new Undefined(),
        public readonly bool|Undefined|null $creditAppliedToBalance = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly AdjustmentStatus|Undefined $status = new Undefined(),
        public readonly array|Undefined $items = new Undefined(),
        public readonly AdjustmentTotals|Undefined $totals = new Undefined(),
        public readonly PayoutTotalsAdjustment|Undefined|null $payoutTotals = new Undefined(),
        public readonly array|Undefined|null $taxRatesUsed = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $updatedAt = new Undefined(),
        public readonly AdjustmentType|Undefined|null $type = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            action: self::optional($data, 'action', fn ($value) => Action::from($value)),
            transactionId: self::optional($data, 'transaction_id'),
            subscriptionId: self::optional($data, 'subscription_id'),
            customerId: self::optional($data, 'customer_id'),
            reason: self::optional($data, 'reason'),
            creditAppliedToBalance: self::optional($data, 'credit_applied_to_balance'),
            currencyCode: self::optional($data, 'currency_code', fn ($value) => CurrencyCode::from($value)),
            status: self::optional($data, 'status', fn ($value) => AdjustmentStatus::from($value)),
            items: self::optionalList($data, 'items', fn ($value) => AdjustmentItem::from($value)),
            totals: self::optional($data, 'totals', fn ($value) => AdjustmentTotals::from($value)),
            payoutTotals: self::optional($data, 'payout_totals', fn ($value) => PayoutTotalsAdjustment::from($value)),
            taxRatesUsed: self::optionalList($data, 'tax_rates_used', fn ($value) => AdjustmentTaxRatesUsed::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            type: self::optional($data, 'type', fn ($value) => AdjustmentType::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'action' => $this->action,
            'transaction_id' => $this->transactionId,
            'subscription_id' => $this->subscriptionId,
            'customer_id' => $this->customerId,
            'reason' => $this->reason,
            'credit_applied_to_balance' => $this->creditAppliedToBalance,
            'currency_code' => $this->currencyCode,
            'status' => $this->status,
            'items' => $this->items,
            'totals' => $this->totals,
            'payout_totals' => $this->payoutTotals,
            'tax_rates_used' => $this->taxRatesUsed,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'type' => $this->type,
        ]);
    }
}
