<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;

/**
 * @deprecated Replaced by \Paddle\SDK\Resources\Transactions\Operations\Price\TransactionNonCatalogPriceWithProduct
 */
class TransactionNonCatalogPriceWithProduct
{
    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    public function __construct(
        public string $description,
        public string|null $name,
        public TimePeriod|null $billingCycle,
        public TimePeriod|null $trialPeriod,
        public TaxMode $taxMode,
        public Money $unitPrice,
        public array $unitPriceOverrides,
        public PriceQuantity $quantity,
        public CustomData|null $customData,
        public TransactionNonCatalogProduct $product,
    ) {
    }
}
