<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations\Update;

class CurrencyConversionUpdate implements \JsonSerializable
{
    public function __construct(
        public readonly bool $enabled,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'enabled' => $this->enabled,
        ];
    }
}
