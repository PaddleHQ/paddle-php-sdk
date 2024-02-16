<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Shared\BillingDetails;
use Paddle\SDK\Notifications\Entities\Shared\Checkout;
use Paddle\SDK\Notifications\Entities\Shared\CollectionMode;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\TransactionOrigin;
use Paddle\SDK\Notifications\Entities\Shared\TransactionPaymentAttempt;
use Paddle\SDK\Notifications\Entities\Shared\TransactionStatus;
use Paddle\SDK\Notifications\Entities\Transaction\TransactionDetails;
use Paddle\SDK\Notifications\Entities\Transaction\TransactionItem;
use Paddle\SDK\Notifications\Entities\Transaction\TransactionTimePeriod;

class Transaction implements Entity
{
    /**
     * @param array<TransactionItem>           $items
     * @param array<TransactionPaymentAttempt> $payments
     */
    private function __construct(
        public string $id,
        public TransactionStatus $status,
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
        public Checkout|null $checkout,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public \DateTimeInterface|null $billedAt,
        public string|null $receiptData,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: TransactionStatus::from($data['status']),
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
            checkout: isset($data['checkout']) ? Checkout::from($data['checkout']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            billedAt: isset($data['billed_at']) ? DateTime::from($data['billed_at']) : null,
            receiptData: $data['receipt_data'] ?? null,
        );
    }
}
