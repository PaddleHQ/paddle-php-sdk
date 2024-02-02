<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Addresses\Operations;

use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateAddress implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly CountryCode|Undefined $countryCode = new Undefined(),
        public readonly string|Undefined|null $description = new Undefined(),
        public readonly string|Undefined|null $firstLine = new Undefined(),
        public readonly string|Undefined|null $secondLine = new Undefined(),
        public readonly string|Undefined|null $city = new Undefined(),
        public readonly string|Undefined|null $postalCode = new Undefined(),
        public readonly string|Undefined|null $region = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'country_code' => $this->countryCode,
            'description' => $this->description,
            'first_line' => $this->firstLine,
            'second_line' => $this->secondLine,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'region' => $this->region,
            'custom_data' => $this->customData,
            'status' => $this->status,
        ]);
    }
}
