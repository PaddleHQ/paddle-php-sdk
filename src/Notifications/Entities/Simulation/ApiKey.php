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
use Paddle\SDK\Notifications\Entities\ApiKey\ApiKeyPermission;
use Paddle\SDK\Notifications\Entities\ApiKey\ApiKeyStatus;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

class ApiKey implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    /**
     * @param array<ApiKeyPermission> $permissions
     */
    private function __construct(
        public string|Undefined $id = new Undefined(),
        public string|Undefined $name = new Undefined(),
        public string|Undefined|null $description = new Undefined(),
        public string|Undefined $key = new Undefined(),
        public ApiKeyStatus|Undefined $status = new Undefined(),
        public array|Undefined $permissions = new Undefined(),
        public \DateTimeInterface|Undefined|null $expiresAt = new Undefined(),
        public \DateTimeInterface|Undefined|null $lastUsedAt = new Undefined(),
        public \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public \DateTimeInterface|Undefined $updatedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            name: self::optional($data, 'name'),
            description: self::optional($data, 'description'),
            key: self::optional($data, 'key'),
            status: self::optional($data, 'status', fn ($value) => ApiKeyStatus::from($value)),
            permissions: self::optionalList($data, 'permissions', fn (string $value) => ApiKeyPermission::from($value)),
            expiresAt: self::optional($data, 'expires_at', fn ($value) => DateTime::from($value)),
            lastUsedAt: self::optional($data, 'last_used_at', fn ($value) => DateTime::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'key' => $this->key,
            'status' => $this->status,
            'permissions' => $this->permissions,
            'expires_at' => $this->expiresAt,
            'last_used_at' => $this->lastUsedAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ]);
    }
}
