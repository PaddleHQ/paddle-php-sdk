<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Subscriptions\Operations\Charge;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionChargeNonCatalogPriceWithProduct implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    public function __construct(
        public string $description,
        public Money $unitPrice,
        public SubscriptionChargeNonCatalogProduct $product,
        public string|Undefined|null $name = new Undefined(),
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
            'product' => $this->product,
            'name' => $this->name,
            'tax_mode' => $this->taxMode,
            'unit_price_overrides' => $this->unitPriceOverrides,
            'quantity' => $this->quantity,
            'custom_data' => $this->customData,
        ]);
    }
}
