<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\ApiRoot;

class RootCallerAccount
{
    private function __construct(
        public string $id,
        public string $name,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
        );
    }
}
