<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Subscription\SubscriptionProrationBillingMode;
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;

class SubscriptionHistoryDetailSubscriptionBillingDateUpdated implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public \DateTimeInterface|null $nextBilledAt,
        public SubscriptionTimePeriod $currentBillingPeriod,
        public string|null $transactionId,
        public SubscriptionProrationBillingMode $prorationBillingMode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            nextBilledAt: isset($data['next_billed_at']) ? DateTime::from($data['next_billed_at']) : null,
            currentBillingPeriod: SubscriptionTimePeriod::from($data['current_billing_period']),
            transactionId: $data['transaction_id'] ?? null,
            prorationBillingMode: SubscriptionProrationBillingMode::from($data['proration_billing_mode']),
        );
    }
}
