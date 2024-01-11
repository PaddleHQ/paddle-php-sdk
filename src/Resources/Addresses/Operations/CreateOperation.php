<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Addresses\Operations;

use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateOperation implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly CountryCode $countryCode,
        public readonly string|null|Undefined $description = new Undefined(),
        public readonly string|null|Undefined $firstLine = new Undefined(),
        public readonly string|null|Undefined $secondLine = new Undefined(),
        public readonly string|null|Undefined $city = new Undefined(),
        public readonly string|null|Undefined $postalCode = new Undefined(),
        public readonly string|null|Undefined $region = new Undefined(),
        public readonly CustomData|null|Undefined $customData = new Undefined(),
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
        ]);
    }
}
