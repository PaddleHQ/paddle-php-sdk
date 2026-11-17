<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Shared\CustomData;

class SubscriptionHistoryDetailSubscriptionCustomDataUpdated implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public CustomData|null $customData,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
        );
    }
}
