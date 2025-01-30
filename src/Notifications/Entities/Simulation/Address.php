<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\CountryCode;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Address implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined|null $description = new Undefined(),
        public readonly string|Undefined|null $firstLine = new Undefined(),
        public readonly string|Undefined|null $secondLine = new Undefined(),
        public readonly string|Undefined|null $city = new Undefined(),
        public readonly string|Undefined|null $postalCode = new Undefined(),
        public readonly string|Undefined|null $region = new Undefined(),
        public readonly CountryCode|Undefined $countryCode = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
        public readonly string|Undefined|null $customerId = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            description: self::optional($data, 'description'),
            firstLine: self::optional($data, 'first_line'),
            secondLine: self::optional($data, 'second_line'),
            city: self::optional($data, 'city'),
            postalCode: self::optional($data, 'postal_code'),
            region: self::optional($data, 'region'),
            countryCode: self::optional($data, 'country_code', fn ($value) => CountryCode::from($value)),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            status: self::optional($data, 'status', fn ($value) => Status::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
            customerId: self::optional($data, 'customer_id'),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'description' => $this->description,
            'first_line' => $this->firstLine,
            'second_line' => $this->secondLine,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'region' => $this->region,
            'country_code' => $this->countryCode,
            'custom_data' => $this->customData,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'import_meta' => $this->importMeta,
            'customer_id' => $this->customerId,
        ]);
    }
}
