<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

class UpdateCheckoutUrl implements \JsonSerializable
{
    public function __construct(
        public readonly string $defaultUrl,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'default_url' => $this->defaultUrl,
        ];
    }
}
