<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

class SubscriptionHistoryDetailSubscriptionCanceled implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionHistoryCanceledEffectiveFrom|null $effectiveFrom,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            effectiveFrom: isset($data['effective_from']) ? SubscriptionHistoryCanceledEffectiveFrom::from($data['effective_from']) : null,
        );
    }
}
