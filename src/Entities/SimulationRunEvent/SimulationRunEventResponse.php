<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SimulationRunEvent;

class SimulationRunEventResponse
{
    private function __construct(
        public string $body,
        public int $statusCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            body: $data['body'],
            statusCode: $data['status_code'],
        );
    }
}
