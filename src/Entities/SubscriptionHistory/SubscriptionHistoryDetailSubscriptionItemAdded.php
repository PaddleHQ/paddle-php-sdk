<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Price;
use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;
use Paddle\SDK\Entities\Subscription\SubscriptionProrationBillingMode;

class SubscriptionHistoryDetailSubscriptionItemAdded implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public Price $price,
        public int $quantity,
        public SubscriptionHistoryItemUpdateSummary $updateSummary,
        public SubscriptionProrationBillingMode $prorationBillingMode,
        public SubscriptionOnPaymentFailure $onPaymentFailure,
        public string|null $transactionId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            price: Price::from($data['price']),
            quantity: $data['quantity'],
            updateSummary: SubscriptionHistoryItemUpdateSummary::from($data['update_summary']),
            prorationBillingMode: SubscriptionProrationBillingMode::from($data['proration_billing_mode']),
            onPaymentFailure: SubscriptionOnPaymentFailure::from($data['on_payment_failure']),
            transactionId: $data['transaction_id'] ?? null,
        );
    }
}
