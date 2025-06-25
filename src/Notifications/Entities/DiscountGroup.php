<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\DiscountGroup\DiscountGroupStatus;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;

class DiscountGroup implements Entity
{
    private function __construct(
        public string $id,
        public string $name,
        public DiscountGroupStatus $status,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public ImportMeta|null $importMeta,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            status: DiscountGroupStatus::from($data['status']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
        );
    }
}
