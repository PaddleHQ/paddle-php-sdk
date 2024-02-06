<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Notification;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Entity;
use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\ImportMeta;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Subscription\SubscriptionDiscount;
use Paddle\SDK\Entities\Subscription\SubscriptionItem;
use Paddle\SDK\Entities\Subscription\SubscriptionScheduledChange;
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;

class NotificationSubscription implements Entity
{
    /**
     * @internal
     *
     * @param array<SubscriptionItem> $items
     */
    protected function __construct(
        public string $id,
        public SubscriptionStatus $status,
        public string $customerId,
        public string $addressId,
        public string|null $businessId,
        public CurrencyCode $currencyCode,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public \DateTimeInterface|null $startedAt,
        public \DateTimeInterface|null $firstBilledAt,
        public \DateTimeInterface|null $nextBilledAt,
        public \DateTimeInterface|null $pausedAt,
        public \DateTimeInterface|null $canceledAt,
        public SubscriptionDiscount|null $discount,
        public CollectionMode $collectionMode,
        public BillingDetails|null $billingDetails,
        public SubscriptionTimePeriod $currentBillingPeriod,
        public TimePeriod $billingCycle,
        public SubscriptionScheduledChange|null $scheduledChange,
        public array $items,
        public CustomData|null $customData,
        public ImportMeta|null $importMeta,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: SubscriptionStatus::from($data['status']),
            customerId: $data['customer_id'],
            addressId: $data['address_id'],
            businessId: $data['business_id'] ?? null,
            currencyCode: CurrencyCode::from($data['currency_code']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            startedAt: isset($data['started_at']) ? DateTime::from($data['started_at']) : null,
            firstBilledAt: isset($data['first_billed_at']) ? DateTime::from($data['first_billed_at']) : null,
            nextBilledAt: isset($data['next_billed_at']) ? DateTime::from($data['next_billed_at']) : null,
            pausedAt: isset($data['paused_at']) ? DateTime::from($data['paused_at']) : null,
            canceledAt: isset($data['canceled_at']) ? DateTime::from($data['canceled_at']) : null,
            discount: isset($data['discount']) ? SubscriptionDiscount::from($data['discount']) : null,
            collectionMode: CollectionMode::from($data['collection_mode']),
            billingDetails: isset($data['billing_details']) ? BillingDetails::from($data['billing_details']) : null,
            currentBillingPeriod: isset($data['current_billing_period'])
                ? SubscriptionTimePeriod::from($data['current_billing_period'])
                : null,
            billingCycle: TimePeriod::from($data['billing_cycle']),
            scheduledChange: isset($data['scheduled_change'])
                ? SubscriptionScheduledChange::from($data['scheduled_change'])
                : null,
            items: array_map(fn (array $item): SubscriptionItem => SubscriptionItem::from($item), $data['items']),
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            importMeta: isset($data['import_meta']) ? new ImportMeta($data['import_meta']) : null,
        );
    }
}
