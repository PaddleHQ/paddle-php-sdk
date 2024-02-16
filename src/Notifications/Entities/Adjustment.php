<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Adjustment\AdjustmentItem;
use Paddle\SDK\Notifications\Entities\Shared\Action;
use Paddle\SDK\Notifications\Entities\Shared\AdjustmentStatus;
use Paddle\SDK\Notifications\Entities\Shared\AdjustmentTotals;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\PayoutTotalsAdjustment;

class Adjustment implements Entity
{
    /**
     * @param array<AdjustmentItem> $items
     */
    private function __construct(
        public string $id,
        public Action $action,
        public string $transactionId,
        public string|null $subscriptionId,
        public string $customerId,
        public string $reason,
        public bool|null $creditAppliedToBalance,
        public CurrencyCode $currencyCode,
        public AdjustmentStatus $status,
        public array $items,
        public AdjustmentTotals $totals,
        public PayoutTotalsAdjustment|null $payoutTotals,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface|null $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            action: Action::from($data['action']),
            transactionId: $data['transaction_id'],
            subscriptionId: $data['subscription_id'] ?? null,
            customerId: $data['customer_id'],
            reason: $data['reason'],
            creditAppliedToBalance: $data['credit_applied_to_balance'] ?? null,
            currencyCode: CurrencyCode::from($data['currency_code']),
            status: AdjustmentStatus::from($data['status']),
            items: array_map(fn (array $item): AdjustmentItem => AdjustmentItem::from($item), $data['items']),
            totals: AdjustmentTotals::from($data['totals']),
            payoutTotals: isset($data['payout_totals']) ? PayoutTotalsAdjustment::from($data['payout_totals']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: isset($data['updated_at']) ? DateTime::from($data['updated_at']) : null,
        );
    }
}
