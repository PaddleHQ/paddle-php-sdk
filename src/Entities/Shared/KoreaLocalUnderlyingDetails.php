<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\Entities\Entity;

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
