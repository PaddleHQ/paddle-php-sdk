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
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;

class SubscriptionHistoryDetailSubscriptionBillingCycleUpdated implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public TimePeriod $billingCycle,
        public SubscriptionTimePeriod $currentBillingPeriod,
        public \DateTimeInterface|null $nextBilledAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            billingCycle: TimePeriod::from($data['billing_cycle']),
            currentBillingPeriod: SubscriptionTimePeriod::from($data['current_billing_period']),
            nextBilledAt: isset($data['next_billed_at']) ? DateTime::from($data['next_billed_at']) : null,
        );
    }
}
