<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class ChargebackFee
{
    private function __construct(
        public string $amount,
        public Original|null $original,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['amount'], isset($data['original']) ? Original::from($data['original']) : null);
    }
}
