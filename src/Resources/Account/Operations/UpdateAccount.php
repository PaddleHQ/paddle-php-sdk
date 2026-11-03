<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Account\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateAccount implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $email = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'email' => $this->email,
        ]);
    }
}
