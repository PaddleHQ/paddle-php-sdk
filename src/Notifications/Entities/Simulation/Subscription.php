<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\BillingDetails;
use Paddle\SDK\Notifications\Entities\Shared\CollectionMode;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\TimePeriod;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionDiscount;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionItem;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionScheduledChange;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionTimePeriod;
use Paddle\SDK\Undefined;

final class Subscription implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    /**
     * @param array<SubscriptionItem> $items
     */
    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined|null $transactionId = new Undefined(),
        public readonly SubscriptionStatus|Undefined $status = new Undefined(),
        public readonly string|Undefined $customerId = new Undefined(),
        public readonly string|Undefined $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $startedAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $firstBilledAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $nextBilledAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $pausedAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $canceledAt = new Undefined(),
        public readonly SubscriptionDiscount|Undefined|null $discount = new Undefined(),
        public readonly CollectionMode|Undefined $collectionMode = new Undefined(),
        public readonly BillingDetails|Undefined|null $billingDetails = new Undefined(),
        public readonly SubscriptionTimePeriod|Undefined|null $currentBillingPeriod = new Undefined(),
        public readonly TimePeriod|Undefined $billingCycle = new Undefined(),
        public readonly SubscriptionScheduledChange|Undefined|null $scheduledChange = new Undefined(),
        public readonly array|Undefined $items = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            transactionId: self::optional($data, 'transaction_id'),
            status: self::optional($data, 'status', fn ($value) => SubscriptionStatus::from($value)),
            customerId: self::optional($data, 'customer_id'),
            addressId: self::optional($data, 'address_id'),
            businessId: self::optional($data, 'business_id'),
            currencyCode: self::optional($data, 'currency_code', fn ($value) => CurrencyCode::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            startedAt: self::optional($data, 'started_at', fn ($value) => DateTime::from($value)),
            firstBilledAt: self::optional($data, 'first_billed_at', fn ($value) => DateTime::from($value)),
            nextBilledAt: self::optional($data, 'next_billed_at', fn ($value) => DateTime::from($value)),
            pausedAt: self::optional($data, 'paused_at', fn ($value) => DateTime::from($value)),
            canceledAt: self::optional($data, 'canceled_at', fn ($value) => DateTime::from($value)),
            discount: self::optional($data, 'discount', fn ($value) => SubscriptionDiscount::from($value)),
            collectionMode: self::optional($data, 'collection_mode', fn ($value) => CollectionMode::from($value)),
            billingDetails: self::optional($data, 'billing_details', fn ($value) => BillingDetails::from($value)),
            currentBillingPeriod: self::optional($data, 'current_billing_period', fn ($value) => SubscriptionTimePeriod::from($value)),
            billingCycle: self::optional($data, 'billing_cycle', fn ($value) => TimePeriod::from($value)),
            scheduledChange: self::optional($data, 'scheduled_change', fn ($value) => SubscriptionScheduledChange::from($value)),
            items: self::optionalList($data, 'items', fn ($value) => SubscriptionItem::from($value)),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'transaction_id' => $this->transactionId,
            'status' => $this->status,
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'currency_code' => $this->currencyCode,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'started_at' => $this->startedAt,
            'first_billed_at' => $this->firstBilledAt,
            'next_billed_at' => $this->nextBilledAt,
            'paused_at' => $this->pausedAt,
            'canceled_at' => $this->canceledAt,
            'discount' => $this->discount,
            'collection_mode' => $this->collectionMode,
            'billing_details' => $this->billingDetails,
            'current_billing_period' => $this->currentBillingPeriod,
            'billing_cycle' => $this->billingCycle,
            'scheduled_change' => $this->scheduledChange,
            'items' => $this->items,
            'custom_data' => $this->customData,
            'import_meta' => $this->importMeta,
        ]);
    }
}
