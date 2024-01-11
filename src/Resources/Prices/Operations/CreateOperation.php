<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Prices\Operations;

use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateOperation implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param UnitPriceOverride[] $unitPriceOverrides
     */
    public function __construct(
        public readonly string $description,
        public readonly string $productId,
        public readonly Money $unitPrice,
        public readonly string|null|Undefined $name = new Undefined(),
        public readonly CatalogType|null|Undefined $type = new Undefined(),
        public readonly array|Undefined $unitPriceOverrides = new Undefined(),
        public readonly TaxMode|Undefined $taxMode = new Undefined(),
        public readonly TimePeriod|null|Undefined $trialPeriod = new Undefined(),
        public readonly TimePeriod|null|Undefined $billingCycle = new Undefined(),
        public readonly PriceQuantity|Undefined $quantity = new Undefined(),
        public readonly CustomData|Undefined $customData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'description' => $this->description,
            'product_id' => $this->productId,
            'unit_price' => $this->unitPrice,
            'name' => $this->name,
            'type' => $this->type,
            'unit_price_overrides' => $this->unitPriceOverrides,
            'trial_period' => $this->trialPeriod,
            'billing_cycle' => $this->billingCycle,
            'custom_data' => $this->customData,
            'tax_mode' => $this->taxMode,
            'quantity' => $this->quantity,
        ]);
    }
}
