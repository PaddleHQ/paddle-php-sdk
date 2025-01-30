<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Customer implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined|null $name = new Undefined(),
        public readonly string|Undefined $email = new Undefined(),
        public readonly bool|Undefined $marketingConsent = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly string|Undefined $locale = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            name: self::optional($data, 'name'),
            email: self::optional($data, 'email'),
            marketingConsent: self::optional($data, 'marketing_consent'),
            status: self::optional($data, 'status', fn ($value) => Status::from($value)),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            locale: self::optional($data, 'locale'),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'marketing_consent' => $this->marketingConsent,
            'status' => $this->status,
            'custom_data' => $this->customData,
            'locale' => $this->locale,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'import_meta' => $this->importMeta,
        ]);
    }
}
