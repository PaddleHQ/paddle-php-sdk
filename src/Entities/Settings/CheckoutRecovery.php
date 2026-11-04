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

class CheckoutRecovery implements Entity
{
    private function __construct(
        public bool $enabled,
        public CheckoutRecoveryDiscount|null $discount,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            enabled: $data['enabled'],
            discount: isset($data['discount']) ? CheckoutRecoveryDiscount::from($data['discount']) : null,
        );
    }
}
