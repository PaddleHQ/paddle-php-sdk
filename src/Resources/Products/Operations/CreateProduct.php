<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Products\Operations;

use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateProduct implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string $name,
        public readonly TaxCategory $taxCategory,
        public readonly CatalogType|Undefined|null $type = new Undefined(),
        public readonly string|Undefined|null $description = new Undefined(),
        public readonly string|Undefined|null $imageUrl = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'name' => $this->name,
            'tax_category' => $this->taxCategory,
            'type' => $this->type,
            'description' => $this->description,
            'image_url' => $this->imageUrl,
            'custom_data' => $this->customData,
        ]);
    }
}
