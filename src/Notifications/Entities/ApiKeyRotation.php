<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\ApiKeyRotation\ApiKeyRotationStatus;

class ApiKeyRotation implements Entity
{
    private function __construct(
        public string $id,
        public string $apiKeyId,
        public ApiKeyRotationStatus $status,
        public int $gracePeriodSeconds,
        public \DateTimeInterface|null $newKeyExpiresAt,
        public \DateTimeInterface|null $expiresAt,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            apiKeyId: $data['api_key_id'],
            status: ApiKeyRotationStatus::from($data['status']),
            gracePeriodSeconds: $data['grace_period_seconds'],
            newKeyExpiresAt: isset($data['new_key_expires_at']) ? DateTime::from($data['new_key_expires_at']) : null,
            expiresAt: isset($data['expires_at']) ? DateTime::from($data['expires_at']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
