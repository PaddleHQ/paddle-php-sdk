<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

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
}
