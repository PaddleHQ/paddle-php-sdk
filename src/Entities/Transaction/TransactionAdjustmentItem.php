<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\Shared\AdjustmentItemTotals;
use Paddle\SDK\Entities\Shared\Type;

class TransactionAdjustmentItem
{
    public function __construct(
        public string $id,
        public string $itemId,
        public Type $type,
        public string|null $amount,
        public TransactionProration $proration,
        public AdjustmentItemTotals $totals,
    ) {
    }
}
