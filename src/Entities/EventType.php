<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;

class EventType implements Entity
{
    private function __construct(
        public EventTypeName $name,
        public string $description,
        public string $group,
        public array $availableVersions,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            EventTypeName::from($data['name']),
            $data['description'],
            $data['group'],
            $data['available_versions'],
        );
    }
}
