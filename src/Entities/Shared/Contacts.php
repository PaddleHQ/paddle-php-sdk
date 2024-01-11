<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class Contacts
{
    public function __construct(
        public string $name,
        public string $email,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['name'], $data['email']);
    }
}
