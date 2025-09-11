<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\DiscountGroups\Operations;

use Paddle\SDK\Entities\DiscountGroup\DiscountGroupStatus;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateDiscountGroup implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $name = new Undefined(),
        public readonly DiscountGroupStatus|Undefined $status = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'name' => $this->name,
            'status' => $this->status,
        ]);
    }
}
