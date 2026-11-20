<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\Entities\Entity;

class CheckoutUrl implements Entity
{
    private function __construct(
        public string|null $defaultUrl,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            defaultUrl: $data['default_url'] ?? null,
        );
    }
}
