<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

class SubscriptionHistoryDetailSubscriptionPaymentMethodAdded implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
        );
    }
}
