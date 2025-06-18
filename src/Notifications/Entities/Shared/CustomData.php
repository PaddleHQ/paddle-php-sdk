<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class CustomData implements \JsonSerializable
{
    public function __construct(
        public array|\JsonSerializable $data,
    ) {
    }

    public function jsonSerialize(): array|\JsonSerializable|\stdClass
    {
        return $this->data === []
            ? (object) []
            : $this->data;
    }
}
