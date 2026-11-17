<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Subscription\SubscriptionOnResume;
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;

class SubscriptionHistoryDetailSubscriptionResumed implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionStatus $status,
        public SubscriptionOnResume $onResume,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            status: SubscriptionStatus::from($data['status']),
            onResume: SubscriptionOnResume::from($data['on_resume']),
        );
    }
}
