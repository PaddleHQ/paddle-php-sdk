<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

class StatementDescriptorPreview
{
    private function __construct(
        public string $default,
        public string $paypal,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            default: $data['default'],
            paypal: $data['paypal'],
        );
    }
}
