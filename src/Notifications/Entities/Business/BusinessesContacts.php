<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Business;

class BusinessesContacts
{
    private function __construct(
        public string $name,
        public string $email,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['name'], $data['email']);
    }
}
