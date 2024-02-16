<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class AdjustmentItemTotals
{
    private function __construct(
        public string $subtotal,
        public string $tax,
        public string $total,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            subtotal: $data['subtotal'],
            tax: $data['tax'],
            total: $data['total'],
        );
    }
}
