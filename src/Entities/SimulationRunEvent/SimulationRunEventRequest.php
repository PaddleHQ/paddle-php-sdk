<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SimulationRunEvent;

class SimulationRunEventRequest
{
    private function __construct(
        public string $body,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            body: $data['body'],
        );
    }
}
