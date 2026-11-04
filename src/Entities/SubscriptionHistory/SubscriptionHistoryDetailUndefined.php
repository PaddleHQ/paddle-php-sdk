<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

/**
 * A history detail for an action this SDK version does not recognise. The raw payload is kept in `$data`.
 */
class SubscriptionHistoryDetailUndefined implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public array $data,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action'] ?? ''),
            data: $data,
        );
    }
}
