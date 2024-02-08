<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Adjustments\Operations\Create;

use Paddle\SDK\Entities\Shared\AdjustmentType;

class AdjustmentItem
{
    public function __construct(
        public string $itemId,
        public AdjustmentType $type,
        public string|null $amount,
    ) {
    }
}
