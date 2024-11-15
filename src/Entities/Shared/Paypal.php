<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class Paypal
{
    private function __construct(
        public string $email,
        public string $reference,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['email'],
            $data['reference'],
        );
    }
}
