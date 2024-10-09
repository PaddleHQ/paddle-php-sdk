<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Entity;
use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\ImportMeta;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;

class TransactionPreviewProduct implements Entity
{
    private function __construct(
        public string|null $id,
        public string $name,
        public string|null $description,
        public CatalogType|null $type,
        public TaxCategory $taxCategory,
        public string|null $imageUrl,
        public CustomData|null $customData,
        public Status $status,
        public ImportMeta|null $importMeta,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            description: $data['description'] ?? null,
            type: CatalogType::from($data['type'] ?? ''),
            taxCategory: TaxCategory::from($data['tax_category']),
            imageUrl: $data['image_url'] ?? null,
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            status: Status::from($data['status']),
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
