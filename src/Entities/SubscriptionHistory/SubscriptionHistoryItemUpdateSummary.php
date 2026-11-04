<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

class SubscriptionHistoryItemUpdateSummary
{
    private function __construct(
        public int $quantityDelta,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            quantityDelta: $data['quantity_delta'],
        );
    }
}
