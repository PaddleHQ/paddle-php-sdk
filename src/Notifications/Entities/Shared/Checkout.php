<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class Checkout
{
    private function __construct(
        public string|null $url,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['url'] ?? null);
    }
}
