<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Adjustment;

class AdjustmentCustomerBalance
{
    private function __construct(
        public string $available,
        public string $reserved,
        public string $used,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['available'], $data['reserved'], $data['used']);
    }
}
