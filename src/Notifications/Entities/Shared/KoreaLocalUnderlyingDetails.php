<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\Notifications\Entities\Entity;

class KoreaLocalUnderlyingDetails implements Entity
{
    private function __construct(
        public KoreaLocalPaymentMethodType $type,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            type: KoreaLocalPaymentMethodType::from($data['type']),
        );
    }
}
