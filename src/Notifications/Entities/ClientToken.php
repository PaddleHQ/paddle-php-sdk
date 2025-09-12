<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\ClientToken\ClientTokenStatus;

class ClientToken implements Entity
{
    private function __construct(
        public string $id,
        public string $name,
        public string $token,
        public string|null $description,
        public ClientTokenStatus $status,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public \DateTimeInterface|null $revokedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            token: $data['token'],
            description: $data['description'] ?? null,
            status: ClientTokenStatus::from($data['status']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            revokedAt: isset($data['revoked_at']) ? DateTime::from($data['revoked_at']) : null,
        );
    }
}
