<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

class UndefinedEntity implements Entity, \JsonSerializable
{
    public function __construct(
        public readonly array $data,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data);
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->data;
    }
}
