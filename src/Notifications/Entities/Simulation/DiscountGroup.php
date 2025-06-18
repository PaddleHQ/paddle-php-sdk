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
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\DiscountGroup\DiscountGroupStatus;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

class DiscountGroup implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    private function __construct(
        public string|Undefined $id = new Undefined(),
        public string|Undefined $name = new Undefined(),
        public DiscountGroupStatus|Undefined $status = new Undefined(),
        public \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public ImportMeta|Undefined|null $importMeta = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            name: self::optional($data, 'name'),
            status: self::optional($data, 'status', fn ($value) => DiscountGroupStatus::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'import_meta' => $this->importMeta,
        ]);
    }
}
