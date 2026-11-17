<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;

class SubscriptionHistoryDetailSubscriptionOneOffChargeApplied implements SubscriptionHistoryDetail
{
    /**
     * @param array<SubscriptionHistoryDetailItem> $items
     */
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionHistoryOneOffChargeAppliedEffectiveFrom $effectiveFrom,
        public array $items,
        public SubscriptionOnPaymentFailure $onPaymentFailure,
        public string|null $transactionId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            effectiveFrom: SubscriptionHistoryOneOffChargeAppliedEffectiveFrom::from($data['effective_from']),
            items: array_map(fn (array $item): SubscriptionHistoryDetailItem => SubscriptionHistoryDetailItem::from($item), $data['items']),
            onPaymentFailure: SubscriptionOnPaymentFailure::from($data['on_payment_failure']),
            transactionId: $data['transaction_id'] ?? null,
        );
    }
}
