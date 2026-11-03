<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateCheckoutUrl implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined|null $defaultUrl = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'default_url' => $this->defaultUrl,
        ]);
    }
}
