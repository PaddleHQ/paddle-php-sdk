<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\ApiKey\ApiKeyPermission;
use Paddle\SDK\Notifications\Entities\ApiKey\ApiKeyStatus;

class ApiKey implements Entity
{
    /**
     * @param array<ApiKeyPermission> $permissions
     */
    private function __construct(
        public string $id,
        public string $name,
        public string|null $description,
        public string $key,
        public ApiKeyStatus $status,
        public array $permissions,
        public \DateTimeInterface|null $expiresAt,
        public \DateTimeInterface|null $lastUsedAt,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            key: $data['key'],
            status: ApiKeyStatus::from($data['status']),
            permissions: array_map(fn (string $item) => ApiKeyPermission::from($item), $data['permissions']),
            expiresAt: isset($data['expires_at']) ? DateTime::from($data['expires_at']) : null,
            lastUsedAt: isset($data['last_used_at']) ? DateTime::from($data['last_used_at']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
