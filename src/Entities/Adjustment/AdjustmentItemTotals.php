<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Adjustment;

use Paddle\SDK\Entities\Shared\AdjustmentItemTotals as SharedAdjustmentItemTotals;
use Paddle\SDK\Entities\Shared\Type;

class AdjustmentItemTotals
{
    public function __construct(
        public string $id,
        public string $itemId,
        public Type $type,
        public string|null $amount,
        public AdjustmentProration $proration,
        public SharedAdjustmentItemTotals $totals,
    ) {
    }

    public function from(array $data): self
    {
        return new self(
            id: $data['id'],
            itemId: $data['item_id'],
            type: Type::from($data['type']),
            amount: $data['amount'] ?? null,
            proration: AdjustmentProration::from($data['proration']),
            totals: SharedAdjustmentItemTotals::from($data['totals']),
        );
    }
}
