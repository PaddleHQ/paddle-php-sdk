<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Shared\Action;
use Paddle\SDK\Entities\Shared\AdjustmentStatus;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\PayoutTotalsAdjustment;
use Paddle\SDK\Entities\Shared\TotalAdjustments;

class SubscriptionAdjustment
{
    /**
     * @param array<SubscriptionAdjustmentItem> $items
     */
    public function __construct(
        public string $id,
        public Action $action,
        public string $transactionId,
        public string|null $subscriptionId,
        public string $customerId,
        public string $reason,
        public bool $creditAppliedToBalance,
        public CurrencyCode $currencyCode,
        public AdjustmentStatus $status,
        public array $items,
        public TotalAdjustments $totals,
        public PayoutTotalsAdjustment $payoutTotals,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            action: Action::from($data['action']),
            transactionId: $data['transaction_id'],
            subscriptionId: $data['subscription_id'],
            customerId: $data['customer_id'],
            reason: $data['reason'],
            creditAppliedToBalance: $data['credit_applied_to_balance'],
            currencyCode: CurrencyCode::from($data['currency_code']),
            status: StatusAdjustment::from($data['status']),
            items: array_map(fn (array $item) => SubscriptionAdjustmentItem::from($item), $data['items']),
            totals: TotalAdjustments::from($data['totals']),
            payoutTotals: PayoutTotalsAdjustment::from($data['payout_totals']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
