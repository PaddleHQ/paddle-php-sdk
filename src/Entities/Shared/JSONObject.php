<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class JSONObject implements \JsonSerializable
{
    public function __construct(
        public array|\JsonSerializable $data,
    ) {
    }

    public function jsonSerialize(): array|\JsonSerializable
    {
        return $this->data;
    }
}
