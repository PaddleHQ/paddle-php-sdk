<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\ApiKeyRotation\ApiKeyRotationStatus;

class ApiKeyRotationCreated implements Entity
{
    private function __construct(
        public string $id,
        public string $apiKeyId,
        public string $newKey,
        public int $gracePeriodSeconds,
        public \DateTimeInterface|null $newKeyExpiresAt,
        public \DateTimeInterface|null $expiresAt,
        public ApiKeyRotationStatus $status,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            apiKeyId: $data['api_key_id'],
            newKey: $data['new_key'],
            gracePeriodSeconds: $data['grace_period_seconds'],
            newKeyExpiresAt: isset($data['new_key_expires_at']) ? DateTime::from($data['new_key_expires_at']) : null,
            expiresAt: isset($data['expires_at']) ? DateTime::from($data['expires_at']) : null,
            status: ApiKeyRotationStatus::from($data['status']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }

    /**
     * Keeps the full new key out of var_dump() and print_r() output.
     *
     * @return array<string, mixed>
     */
    public function __debugInfo(): array
    {
        return array_merge(get_object_vars($this), ['newKey' => '[REDACTED]']);
    }
}
