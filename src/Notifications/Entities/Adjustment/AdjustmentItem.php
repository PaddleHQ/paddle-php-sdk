<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Adjustment;

use Paddle\SDK\Notifications\Entities\Shared\AdjustmentItemTotals;
use Paddle\SDK\Notifications\Entities\Shared\AdjustmentProration;
use Paddle\SDK\Notifications\Entities\Shared\AdjustmentType;

class AdjustmentItem
{
    private function __construct(
        public string $id,
        public string $itemId,
        public AdjustmentType $type,
        public string|null $amount,
        public AdjustmentProration|null $proration,
        public AdjustmentItemTotals $totals,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            itemId: $data['item_id'],
            type: AdjustmentType::from($data['type']),
            amount: $data['amount'] ?? null,
            proration: $data['proration'] ? AdjustmentProration::from($data['proration']) : null,
            totals: AdjustmentItemTotals::from($data['totals']),
        );
    }
}
