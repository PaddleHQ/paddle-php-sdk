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
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;

class SubscriptionHistoryDetailSubscriptionActivated implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionStatus $status,
        public \DateTimeInterface|null $firstBilledAt,
        public \DateTimeInterface|null $nextBilledAt,
        public SubscriptionTimePeriod $currentBillingPeriod,
        public string $transactionId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            status: SubscriptionStatus::from($data['status']),
            firstBilledAt: isset($data['first_billed_at']) ? DateTime::from($data['first_billed_at']) : null,
            nextBilledAt: isset($data['next_billed_at']) ? DateTime::from($data['next_billed_at']) : null,
            currentBillingPeriod: SubscriptionTimePeriod::from($data['current_billing_period']),
            transactionId: $data['transaction_id'],
        );
    }
}
