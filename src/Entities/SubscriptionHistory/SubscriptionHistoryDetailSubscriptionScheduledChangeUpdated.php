<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Subscription\SubscriptionScheduledChange;

class SubscriptionHistoryDetailSubscriptionScheduledChangeUpdated implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionScheduledChange $scheduledChange,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            scheduledChange: SubscriptionScheduledChange::from($data['scheduled_change']),
        );
    }
}
