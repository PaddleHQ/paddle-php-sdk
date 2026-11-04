<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class Actor
{
    private function __construct(
        public ActorType $type,
        public string|null $id,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            type: ActorType::from($data['type']),
            id: $data['id'] ?? null,
        );
    }
}
