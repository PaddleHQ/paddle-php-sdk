<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Prices\Operations;

use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdatePrice implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param UnitPriceOverride[] $unitPriceOverrides
     */
    public function __construct(
        public readonly string|Undefined $description = new Undefined(),
        public readonly string|Undefined|null $name = new Undefined(),
        public readonly CatalogType|Undefined $type = new Undefined(),
        public readonly TimePeriod|Undefined|null $billingCycle = new Undefined(),
        public readonly TimePeriod|Undefined|null $trialPeriod = new Undefined(),
        public readonly TaxMode|Undefined $taxMode = new Undefined(),
        public readonly Money|Undefined $unitPrice = new Undefined(),
        public readonly array|Undefined $unitPriceOverrides = new Undefined(),
        public readonly PriceQuantity|Undefined $quantity = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'description' => $this->description,
            'name' => $this->name,
            'type' => $this->type,
            'billing_cycle' => $this->billingCycle,
            'trial_period' => $this->trialPeriod,
            'tax_mode' => $this->taxMode,
            'unit_price' => $this->unitPrice,
            'unit_price_overrides' => $this->unitPriceOverrides,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'custom_data' => $this->customData,
        ]);
    }
}
