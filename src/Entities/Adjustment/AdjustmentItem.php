<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Adjustment;

class AdjustmentItem
{
    public function __construct(
        public string $itemId,
        public AdjustmentType $type,
        public string|null $amount,
    ) {
    }
}
