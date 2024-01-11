<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\Checkout;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\StatusTransaction;
use Paddle\SDK\Entities\Shared\TransactionOrigin;
use Paddle\SDK\Entities\Shared\TransactionPaymentAttempt;
use Paddle\SDK\Entities\Subscription\SubscriptionAdjustment;
use Paddle\SDK\Entities\Subscription\SubscriptionDetails;
use Paddle\SDK\Entities\Subscription\SubscriptionTimePeriod;
use Paddle\SDK\Entities\Subscription\SubscriptionTransactionItem;

class SubscriptionTransaction implements Entity
{
    /**
     * @param array<SubscriptionTransactionItem> $items
     * @param array<TransactionPaymentAttempt>   $payments
     * @param array<SubscriptionAdjustment>      $adjustments
     */
    public function __construct(
        public string $id,
        public StatusTransaction $status,
        public string|null $customerId,
        public string|null $addressId,
        public string|null $businessId,
        public CustomData|null $customData,
        public CurrencyCode $currencyCode,
        public TransactionOrigin $origin,
        public string|null $subscriptionId,
        public string|null $invoiceId,
        public string|null $invoiceNumber,
        public CollectionMode $collectionMode,
        public string|null $discountId,
        public BillingDetails|null $billingDetails,
        public SubscriptionTimePeriod $billingPeriod,
        public array $items,
        public SubscriptionDetails $details,
        public array $payments,
        public Checkout $checkout,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public \DateTimeInterface|null $billedAt,
        public Customer $customer,
        public Address $address,
        public Business $business,
        public Discount $discount,
        public array $adjustments,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: StatusTransaction::from($data['status']),
            customerId: $data['customer_id'] ?? null,
            addressId: $data['address_id'] ?? null,
            businessId: $data['business_id'] ?? null,
            customData: new CustomData($data['custom_data'] ?? []),
            currencyCode: CurrencyCode::from($data['currency_code']),
            origin: TransactionOrigin::from($data['origin']),
            subscriptionId: $data['subscription_id'] ?? null,
            invoiceId: $data['invoice_id'] ?? null,
            invoiceNumber: $data['invoice_number'] ?? null,
            collectionMode: CollectionMode::from($data['collection_mode']),
            discountId: $data['discount_id'] ?? null,
            billingDetails: BillingDetails::from($data['billing_details']),
            billingPeriod: SubscriptionTimePeriod::from($data['billing_period']),
            items: $data['items'],
            details: SubscriptionDetails::from($data['details']),
            payments: $data['payments'],
            checkout: Checkout::from($data['checkout']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            billedAt: isset($data['billed_at']) ? DateTime::from($data['billed_at']) : null,
            customer: Customer::from($data['customer']),
            address: Address::from($data['address']),
            business: Business::from($data['business']),
            discount: Discount::from($data['discount']),
            adjustments: $data['adjustments'],
        );
    }
}
