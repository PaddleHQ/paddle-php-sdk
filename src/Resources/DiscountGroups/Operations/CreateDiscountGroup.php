<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\DiscountGroups\Operations;

class CreateDiscountGroup implements \JsonSerializable
{
    public function __construct(
        public readonly string $name,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
