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
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;

class SubscriptionHistoryDetailSubscriptionRenewed implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public \DateTimeInterface $nextBilledAt,
        public SubscriptionTimePeriod $currentBillingPeriod,
        public string $transactionId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            nextBilledAt: DateTime::from($data['next_billed_at']),
            currentBillingPeriod: SubscriptionTimePeriod::from($data['current_billing_period']),
            transactionId: $data['transaction_id'],
        );
    }
}
