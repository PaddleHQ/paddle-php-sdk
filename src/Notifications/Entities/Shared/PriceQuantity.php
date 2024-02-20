<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class PriceQuantity
{
    private function __construct(
        public int $minimum,
        public int $maximum,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['minimum'], $data['maximum']);
    }
}
