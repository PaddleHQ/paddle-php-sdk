<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Collections\PriceWithIncludesCollection;
use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;

class ProductWithIncludes implements Entity
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $description,
        public CatalogType|null $type,
        public TaxCategory $taxCategory,
        public null|string $imageUrl,
        public CustomData|null $customData,
        public Status $status,
        public \DateTimeInterface|null $createdAt,
        public PriceWithIncludesCollection $prices,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            type: CatalogType::tryFrom($data['type'] ?? ''),
            taxCategory: TaxCategory::from($data['tax_category']),
            imageUrl: $data['image_url'] ?? null,
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            status: Status::from($data['status']),
            createdAt: isset($data['created_at']) ? DateTime::from($data['created_at']) : null,
            prices: PriceWithIncludesCollection::from($data['prices'] ?? []),
        );
    }
}
