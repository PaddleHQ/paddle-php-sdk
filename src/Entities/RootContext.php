<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\ApiRoot\RootApi;
use Paddle\SDK\Entities\ApiRoot\RootCaller;

class RootContext implements Entity
{
    private function __construct(
        public RootApi $api,
        public RootCaller $caller,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            api: RootApi::from($data['api']),
            caller: RootCaller::from($data['caller']),
        );
    }
}
