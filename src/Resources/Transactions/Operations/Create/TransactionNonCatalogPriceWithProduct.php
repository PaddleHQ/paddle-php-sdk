<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Create;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\Entities\Transaction\TransactionNonCatalogProduct;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class TransactionNonCatalogPriceWithProduct implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    public function __construct(
        public string $description,
        public Money $unitPrice,
        public TransactionNonCatalogProduct $product,
        public string|null|Undefined $name = new Undefined(),
        public TimePeriod|null|Undefined $billingCycle = new Undefined(),
        public TimePeriod|null|Undefined $trialPeriod = new Undefined(),
        public TaxMode|Undefined $taxMode = new Undefined(),
        public array|Undefined $unitPriceOverrides = new Undefined(),
        public PriceQuantity|Undefined $quantity = new Undefined(),
        public CustomData|null|Undefined $customData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
            'product' => $this->product,
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
