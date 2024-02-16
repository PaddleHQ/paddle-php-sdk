<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Status;

class Customer implements Entity
{
    private function __construct(
        public string $id,
        public string|null $name,
        public string $email,
        public bool $marketingConsent,
        public Status $status,
        public CustomData|null $customData,
        public string $locale,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public ImportMeta|null $importMeta,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            email: $data['email'],
            marketingConsent: $data['marketing_consent'],
            status: Status::from($data['status']),
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            locale: $data['locale'],
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
        );
    }
}
