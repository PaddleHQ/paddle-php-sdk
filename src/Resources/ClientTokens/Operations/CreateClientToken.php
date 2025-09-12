<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\ClientTokens\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateClientToken implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string $name,
        public readonly string|Undefined|null $description = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }
}
