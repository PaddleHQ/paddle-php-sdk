<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Price;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class TransactionNonCatalogPrice implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    public function __construct(
        public string $description,
        public Money $unitPrice,
        public string $productId,
        public string|Undefined|null $name = new Undefined(),
        public TimePeriod|Undefined|null $billingCycle = new Undefined(),
        public TimePeriod|Undefined|null $trialPeriod = new Undefined(),
        public TaxMode|Undefined $taxMode = new Undefined(),
        public array|Undefined $unitPriceOverrides = new Undefined(),
        public PriceQuantity|Undefined $quantity = new Undefined(),
        public CustomData|Undefined|null $customData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
            'product_id' => $this->productId,
            'name' => $this->name,
            'billing_cycle' => $this->billingCycle,
            'trial_period' => $this->trialPeriod,
            'tax_mode' => $this->taxMode,
            'unit_price_overrides' => $this->unitPriceOverrides,
            'quantity' => $this->quantity,
            'custom_data' => $this->customData,
        ]);
    }
}
