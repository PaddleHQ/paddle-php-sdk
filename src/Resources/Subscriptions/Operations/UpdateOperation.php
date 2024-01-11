<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Subscription\SubscriptionItems;
use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;
use Paddle\SDK\Entities\Subscription\SubscriptionProrationBillingMode;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionDiscount;
use Paddle\SDK\Undefined;

class UpdateOperation implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<SubscriptionItems> $items
     */
    public function __construct(
        public readonly string|Undefined $customerId = new Undefined(),
        public readonly string|Undefined $addressId = new Undefined(),
        public readonly string|null|Undefined $businessId = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly \DateTimeInterface|Undefined $nextBilledAt = new Undefined(),
        public readonly SubscriptionDiscount|null|Undefined $discount = new Undefined(),
        public readonly CollectionMode|Undefined $collectionMode = new Undefined(),
        public readonly BillingDetails|null|Undefined $billingDetails = new Undefined(),
        public readonly null|Undefined $scheduledChange = new Undefined(),
        public readonly array|Undefined $items = new Undefined(),
        public readonly CustomData|null|Undefined $customData = new Undefined(),
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
