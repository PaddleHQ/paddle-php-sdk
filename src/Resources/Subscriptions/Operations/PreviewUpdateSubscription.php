<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Subscription\SubscriptionItems;
use Paddle\SDK\Entities\Subscription\SubscriptionItemsWithPrice;
use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;
use Paddle\SDK\Entities\Subscription\SubscriptionProrationBillingMode;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionDiscount;
use Paddle\SDK\Undefined;

class PreviewUpdateSubscription implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<SubscriptionItems|SubscriptionItemsWithPrice> $items
     */
    public function __construct(
        public readonly string|Undefined $customerId = new Undefined(),
        public readonly string|Undefined $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly \DateTimeInterface|Undefined $nextBilledAt = new Undefined(),
        public readonly SubscriptionDiscount|Undefined|null $discount = new Undefined(),
        public readonly CollectionMode|Undefined $collectionMode = new Undefined(),
        public readonly BillingDetails|Undefined|null $billingDetails = new Undefined(),
        public readonly Undefined|null $scheduledChange = new Undefined(),
        public readonly array|Undefined $items = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly SubscriptionProrationBillingMode|Undefined $prorationBillingMode = new Undefined(),
        public readonly SubscriptionOnPaymentFailure|Undefined $onPaymentFailure = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'currency_code' => $this->currencyCode,
            'next_billed_at' => is_a($this->nextBilledAt, \DateTimeInterface::class) ? DateTime::from($this->nextBilledAt)?->format() : $this->nextBilledAt,
            'discount' => $this->discount,
            'collection_mode' => $this->collectionMode,
            'billing_details' => $this->billingDetails,
            'scheduled_change' => $this->scheduledChange,
            'items' => $this->items,
            'custom_data' => $this->customData,
            'proration_billing_mode' => $this->prorationBillingMode,
            'on_payment_failure' => $this->onPaymentFailure,
        ]);
    }
}
