<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Price;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class TransactionNonCatalogProduct implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public string $name,
        public TaxCategory $taxCategory,
        public string|Undefined|null $description = new Undefined(),
        public string|Undefined|null $imageUrl = new Undefined(),
        public CustomData|Undefined|null $customData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'name' => $this->name,
            'description' => $this->description,
            'tax_category' => $this->taxCategory,
            'image_url' => $this->imageUrl,
            'custom_data' => $this->customData,
        ]);
    }
}
