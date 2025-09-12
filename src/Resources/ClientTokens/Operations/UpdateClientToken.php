<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\ClientTokens\Operations;

use Paddle\SDK\Entities\ClientToken\ClientTokenStatus;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateClientToken implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly ClientTokenStatus|Undefined $status = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'status' => $this->status,
        ]);
    }
}
