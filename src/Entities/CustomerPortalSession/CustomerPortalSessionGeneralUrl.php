<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\CustomerPortalSession;

use Paddle\SDK\Notifications\Entities\Entity;

class CustomerPortalSessionGeneralUrl implements Entity
{
    private function __construct(
        public string $overview,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            overview: $data['overview'],
        );
    }
}
