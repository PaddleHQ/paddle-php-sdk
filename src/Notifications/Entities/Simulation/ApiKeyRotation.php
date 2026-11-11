<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\ApiKeyRotation\ApiKeyRotationStatus;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class ApiKeyRotation implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined $apiKeyId = new Undefined(),
        public readonly ApiKeyRotationStatus|Undefined $status = new Undefined(),
        public readonly int|Undefined $gracePeriodSeconds = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $newKeyExpiresAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $expiresAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            apiKeyId: self::optional($data, 'api_key_id'),
            status: self::optional($data, 'status', fn ($value) => ApiKeyRotationStatus::from($value)),
            gracePeriodSeconds: self::optional($data, 'grace_period_seconds'),
            newKeyExpiresAt: self::optional($data, 'new_key_expires_at', fn ($value) => DateTime::from($value)),
            expiresAt: self::optional($data, 'expires_at', fn ($value) => DateTime::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'api_key_id' => $this->apiKeyId,
            'status' => $this->status,
            'grace_period_seconds' => $this->gracePeriodSeconds,
            'new_key_expires_at' => $this->newKeyExpiresAt,
            'expires_at' => $this->expiresAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ]);
    }
}
