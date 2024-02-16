<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Shared\CatalogType;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Money;
use Paddle\SDK\Notifications\Entities\Shared\PriceQuantity;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Shared\TaxMode;
use Paddle\SDK\Notifications\Entities\Shared\TimePeriod;
use Paddle\SDK\Notifications\Entities\Shared\UnitPriceOverride;

class Price implements Entity
{
    /**
     * @internal
     *
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    protected function __construct(
        public string $id,
        public string $productId,
        public string|null $name,
        public string $description,
        public CatalogType|null $type,
        public TimePeriod|null $billingCycle,
        public TimePeriod|null $trialPeriod,
        public TaxMode|null $taxMode,
        public Money $unitPrice,
        public array $unitPriceOverrides,
        public PriceQuantity $quantity,
        public Status $status,
        public CustomData|null $customData,
        public ImportMeta|null $importMeta,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            productId: $data['product_id'],
            name: $data['name'] ?? null,
            description: $data['description'],
            type: isset($data['type']) ? CatalogType::from($data['type']) : null,
            billingCycle: isset($data['billing_cycle']) ? TimePeriod::from($data['billing_cycle']) : null,
            trialPeriod: isset($data['trial_period']) ? TimePeriod::from($data['trial_period']) : null,
            taxMode: isset($data['tax_mode']) ? TaxMode::from($data['tax_mode']) : null,
            unitPrice: Money::from($data['unit_price']),
            unitPriceOverrides: array_map(
                fn (array $override): UnitPriceOverride => UnitPriceOverride::from($override),
                $data['unit_price_overrides'] ?? [],
            ),
            quantity: PriceQuantity::from($data['quantity']),
            status: Status::from($data['status']),
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
        );
    }
}
