<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

class CheckoutPaymentMethodSetting
{
    private function __construct(
        public bool $enabled,
        public bool $available,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            enabled: $data['enabled'],
            available: $data['available'],
        );
    }
}
