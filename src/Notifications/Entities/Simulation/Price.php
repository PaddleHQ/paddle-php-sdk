<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Shared\CatalogType;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Money;
use Paddle\SDK\Notifications\Entities\Shared\PriceQuantity;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Shared\TaxMode;
use Paddle\SDK\Notifications\Entities\Shared\TimePeriod;
use Paddle\SDK\Notifications\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Price implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined $productId = new Undefined(),
        public readonly string|Undefined|null $name = new Undefined(),
        public readonly string|Undefined $description = new Undefined(),
        public readonly CatalogType|Undefined|null $type = new Undefined(),
        public readonly TimePeriod|Undefined|null $billingCycle = new Undefined(),
        public readonly TimePeriod|Undefined|null $trialPeriod = new Undefined(),
        public readonly TaxMode|Undefined $taxMode = new Undefined(),
        public readonly Money|Undefined $unitPrice = new Undefined(),
        public readonly array|Undefined $unitPriceOverrides = new Undefined(),
        public readonly PriceQuantity|Undefined $quantity = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $updatedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            productId: self::optional($data, 'product_id'),
            name: self::optional($data, 'name'),
            description: self::optional($data, 'description'),
            type: self::optional($data, 'type', fn ($value) => CatalogType::from($value)),
            billingCycle: self::optional($data, 'billing_cycle', fn ($value) => TimePeriod::from($value)),
            trialPeriod: self::optional($data, 'trial_period', fn ($value) => TimePeriod::from($value)),
            taxMode: self::optional($data, 'tax_mode', fn ($value) => TaxMode::from($value)),
            unitPrice: self::optional($data, 'unit_price', fn ($value) => Money::from($value)),
            unitPriceOverrides: self::optionalList($data, 'unit_price_overrides', fn ($value) => UnitPriceOverride::from($value)),
            quantity: self::optional($data, 'quantity', fn ($value) => PriceQuantity::from($value)),
            status: self::optional($data, 'status', fn ($value) => Status::from($value)),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'product_id' => $this->productId,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'billing_cycle' => $this->billingCycle,
            'trial_period' => $this->trialPeriod,
            'tax_mode' => $this->taxMode,
            'unit_price' => $this->unitPrice,
            'unit_price_overrides' => $this->unitPriceOverrides,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'custom_data' => $this->customData,
            'import_meta' => $this->importMeta,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ]);
    }
}
