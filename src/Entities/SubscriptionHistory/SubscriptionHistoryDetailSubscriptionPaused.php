<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Subscription\SubscriptionStatus;

class SubscriptionHistoryDetailSubscriptionPaused implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionHistoryPausedEffectiveFrom $effectiveFrom,
        public SubscriptionStatus $status,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            effectiveFrom: SubscriptionHistoryPausedEffectiveFrom::from($data['effective_from']),
            status: SubscriptionStatus::from($data['status']),
        );
    }
}
