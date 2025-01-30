<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Shared\CatalogType;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Shared\TaxCategory;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Product implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined|null $name = new Undefined(),
        public readonly string|Undefined|null $description = new Undefined(),
        public readonly CatalogType|Undefined|null $type = new Undefined(),
        public readonly TaxCategory|Undefined $taxCategory = new Undefined(),
        public readonly string|Undefined|null $imageUrl = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $updatedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            name: self::optional($data, 'name'),
            description: self::optional($data, 'description'),
            type: self::optional($data, 'type', fn ($value) => CatalogType::from($value)),
            taxCategory: self::optional($data, 'tax_category', fn ($value) => TaxCategory::from($value)),
            imageUrl: self::optional($data, 'image_url'),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            status: self::optional($data, 'status', fn ($value) => Status::from($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'tax_category' => $this->taxCategory,
            'image_url' => $this->imageUrl,
            'custom_data' => $this->customData,
            'status' => $this->status,
            'import_meta' => $this->importMeta,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ]);
    }
}
