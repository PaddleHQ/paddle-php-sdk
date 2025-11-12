<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\Entities\Entity;

/**
 * @deprecated
 */
class PaymentMethodUnderlyingDetails implements Entity
{
    private function __construct(
        public KoreaLocalUnderlyingDetails|null $koreaLocal,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            koreaLocal: isset($data['korea_local'])
                ? KoreaLocalUnderlyingDetails::from($data['korea_local'])
                : null,
        );
    }
}
