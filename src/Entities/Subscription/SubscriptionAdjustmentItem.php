<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Adjustment\AdjustmentType;
use Paddle\SDK\Entities\Shared\AdjustmentItemTotals;

class SubscriptionAdjustmentItem
{
    public function __construct(
        public string $itemId,
        public AdjustmentType $type,
        public string|null $amount,
        public SubscriptionProration $proration,
        public AdjustmentItemTotals $totals,
    ) {
    }
}
