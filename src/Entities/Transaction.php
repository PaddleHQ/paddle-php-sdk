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
use Paddle\SDK\Entities\Transaction\TransactionDetails;
use Paddle\SDK\Entities\Transaction\TransactionItem;
use Paddle\SDK\Entities\Transaction\TransactionTimePeriod;

class Transaction implements Entity
{
    /**
     * @param array<TransactionItem>           $items
     * @param array<TransactionPaymentAttempt> $payments
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
        public TransactionTimePeriod|null $billingPeriod,
        public array $items,
        public TransactionDetails $details,
        public array $payments,
        public Checkout $checkout,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public \DateTimeInterface|null $billedAt,
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
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            currencyCode: CurrencyCode::from($data['currency_code']),
            origin: TransactionOrigin::from($data['origin']),
            subscriptionId: $data['subscription_id'] ?? null,
            invoiceId: $data['invoice_id'] ?? null,
            invoiceNumber: $data['invoice_number'] ?? null,
            collectionMode: CollectionMode::from($data['collection_mode']),
            discountId: $data['discount_id'] ?? null,
            billingDetails: isset($data['billing_details']) ? BillingDetails::from($data['billing_details']) : null,
            billingPeriod: isset($data['billing_period']) ? TransactionTimePeriod::from($data['billing_period']) : null,
            items: array_map(fn (array $item): TransactionItem => TransactionItem::from($item), $data['items'] ?? []),
            details: TransactionDetails::from($data['details']),
            payments: array_map(fn (array $payment): TransactionPaymentAttempt => TransactionPaymentAttempt::from($payment), $data['payments'] ?? []),
            checkout: isset($data['checkout']) ? new Checkout($data['checkout']['url'] ?? null) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            billedAt: isset($data['billed_at']) ? DateTime::from($data['billed_at']) : null,
        );
    }
}
