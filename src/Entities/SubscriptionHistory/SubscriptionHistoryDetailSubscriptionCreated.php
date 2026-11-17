<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Address;
use Paddle\SDK\Entities\Business;
use Paddle\SDK\Entities\Customer;
use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;

class SubscriptionHistoryDetailSubscriptionCreated implements SubscriptionHistoryDetail
{
    /**
     * @param array<SubscriptionHistoryDetailItem>|null $items
     */
    private function __construct(
        public SubscriptionHistoryAction $action,
        public SubscriptionStatus|null $status,
        public CollectionMode|null $collectionMode,
        public BillingDetails|null $billingDetails,
        public Customer|null $customer,
        public Address|null $address,
        public Business|null $business,
        public CurrencyCode|null $currencyCode,
        public SubscriptionTimePeriod|null $currentBillingPeriod,
        public TimePeriod|null $billingCycle,
        public array|null $items,
        public CustomData|null $customData,
        public SubscriptionHistoryDiscount|null $discount,
        public bool|null $hasPaymentMethod,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            status: isset($data['status']) ? SubscriptionStatus::from($data['status']) : null,
            collectionMode: isset($data['collection_mode']) ? CollectionMode::from($data['collection_mode']) : null,
            billingDetails: isset($data['billing_details']) ? BillingDetails::from($data['billing_details']) : null,
            customer: isset($data['customer']) ? Customer::from($data['customer']) : null,
            address: isset($data['address']) ? Address::from($data['address']) : null,
            business: isset($data['business']) ? Business::from($data['business']) : null,
            currencyCode: isset($data['currency_code']) ? CurrencyCode::from($data['currency_code']) : null,
            currentBillingPeriod: isset($data['current_billing_period']) ? SubscriptionTimePeriod::from($data['current_billing_period']) : null,
            billingCycle: isset($data['billing_cycle']) ? TimePeriod::from($data['billing_cycle']) : null,
            items: isset($data['items']) ? array_map(fn (array $item): SubscriptionHistoryDetailItem => SubscriptionHistoryDetailItem::from($item), $data['items']) : null,
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            discount: isset($data['discount']) ? SubscriptionHistoryDiscount::from($data['discount']) : null,
            hasPaymentMethod: $data['has_payment_method'] ?? null,
        );
    }
}
