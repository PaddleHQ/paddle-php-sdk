<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Subscription;

use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\CatalogType;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Money;
use Paddle\SDK\Notifications\Entities\Shared\PriceQuantity;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Shared\TaxMode;
use Paddle\SDK\Notifications\Entities\Shared\TimePeriod;
use Paddle\SDK\Notifications\Entities\Shared\UnitPriceOverride;

class SubscriptionPrice
{
    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    private function __construct(
        public string $id,
        public string $productId,
        public string|null $name,
        public string $description,
        public CatalogType|null $type,
        public TimePeriod|null $billingCycle,
        public TimePeriod|null $trialPeriod,
        public TaxMode $taxMode,
        public Money $unitPrice,
        public array $unitPriceOverrides,
        public PriceQuantity|null $quantity,
        public Status|null $status,
        public CustomData|null $customData,
        public ImportMeta|null $importMeta,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
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
            taxMode: TaxMode::from($data['tax_mode']),
            unitPrice: Money::from($data['unit_price']),
            unitPriceOverrides: array_map(
                fn (array $override): UnitPriceOverride => UnitPriceOverride::from($override),
                $data['unit_price_overrides'] ?? [],
            ),
            quantity: isset($data['quantity']) ? PriceQuantity::from($data['quantity']) : null,
            status: isset($data['status']) ? Status::from($data['status']) : null,
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
