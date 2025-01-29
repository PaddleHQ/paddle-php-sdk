<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Revise;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class TransactionReviseAddress implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $firstLine = new Undefined(),
        public readonly string|Undefined|null $secondLine = new Undefined(),
        public readonly string|Undefined $city = new Undefined(),
        public readonly string|Undefined $region = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'first_line' => $this->firstLine,
            'second_line' => $this->secondLine,
            'city' => $this->city,
            'region' => $this->region,
        ]);
    }
}
