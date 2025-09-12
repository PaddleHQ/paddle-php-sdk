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
use Paddle\SDK\Notifications\Entities\ClientToken\ClientTokenStatus;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

class ClientToken implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    private function __construct(
        public string|Undefined $id = new Undefined(),
        public string|Undefined $name = new Undefined(),
        public string|Undefined $token = new Undefined(),
        public string|Undefined|null $description = new Undefined(),
        public ClientTokenStatus|Undefined $status = new Undefined(),
        public \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public \DateTimeInterface|Undefined|null $revokedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            name: self::optional($data, 'name'),
            token: self::optional($data, 'token'),
            description: self::optional($data, 'description'),
            status: self::optional($data, 'status', fn ($value) => ClientTokenStatus::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            revokedAt: self::optional($data, 'revoked_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'name' => $this->name,
            'token' => $this->token,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'revoked_at' => $this->revokedAt,
        ]);
    }
}
