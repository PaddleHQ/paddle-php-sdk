<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\Entities\Settings\BalanceCurrencyCode;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateBalanceCurrency implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly BalanceCurrencyCode|Undefined $preferred = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'preferred' => $this->preferred,
        ]);
    }
}
