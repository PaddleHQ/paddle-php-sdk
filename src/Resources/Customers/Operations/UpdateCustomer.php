<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Customers\Operations;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateCustomer implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $email = new Undefined(),
        public readonly string|Undefined|null $name = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly string|Undefined $locale = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'email' => $this->email,
            'name' => $this->name,
            'custom_data' => $this->customData,
            'locale' => $this->locale,
            'status' => $this->status,
        ]);
    }
}
