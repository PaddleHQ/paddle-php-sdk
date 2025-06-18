<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\BillingDetails;
use Paddle\SDK\Notifications\Entities\Shared\Checkout;
use Paddle\SDK\Notifications\Entities\Shared\CollectionMode;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\TransactionOrigin;
use Paddle\SDK\Notifications\Entities\Shared\TransactionPaymentAttempt;
use Paddle\SDK\Notifications\Entities\Shared\TransactionStatus;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Notifications\Entities\Transaction\TransactionDetails;
use Paddle\SDK\Notifications\Entities\Transaction\TransactionItem;
use Paddle\SDK\Notifications\Entities\Transaction\TransactionTimePeriod;
use Paddle\SDK\Undefined;

final class Transaction implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    /**
     * @param array<TransactionItem>           $items
     * @param array<TransactionPaymentAttempt> $payments
     */
    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly TransactionStatus|Undefined $status = new Undefined(),
        public readonly string|Undefined|null $customerId = new Undefined(),
        public readonly string|Undefined|null $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly TransactionOrigin|Undefined $origin = new Undefined(),
        public readonly string|Undefined|null $subscriptionId = new Undefined(),
        public readonly string|Undefined|null $invoiceId = new Undefined(),
        public readonly string|Undefined|null $invoiceNumber = new Undefined(),
        public readonly CollectionMode|Undefined $collectionMode = new Undefined(),
        public readonly string|Undefined|null $discountId = new Undefined(),
        public readonly BillingDetails|Undefined|null $billingDetails = new Undefined(),
        public readonly TransactionTimePeriod|Undefined|null $billingPeriod = new Undefined(),
        public readonly array|Undefined $items = new Undefined(),
        public readonly TransactionDetails|Undefined $details = new Undefined(),
        public readonly array|Undefined $payments = new Undefined(),
        public readonly Checkout|Undefined|null $checkout = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $billedAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $revisedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            status: self::optional($data, 'status', fn ($value) => TransactionStatus::from($value)),
            customerId: self::optional($data, 'customer_id'),
            addressId: self::optional($data, 'address_id'),
            businessId: self::optional($data, 'business_id'),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            currencyCode: self::optional($data, 'currency_code', fn ($value) => CurrencyCode::from($value)),
            origin: self::optional($data, 'origin', fn ($value) => TransactionOrigin::from($value)),
            subscriptionId: self::optional($data, 'subscription_id'),
            invoiceId: self::optional($data, 'invoice_id'),
            invoiceNumber: self::optional($data, 'invoice_number'),
            collectionMode: self::optional($data, 'collection_mode', fn ($value) => CollectionMode::from($value)),
            discountId: self::optional($data, 'discount_id'),
            billingDetails: self::optional($data, 'billing_details', fn ($value) => BillingDetails::from($value)),
            billingPeriod: self::optional($data, 'billing_period', fn ($value) => TransactionTimePeriod::from($value)),
            items: self::optionalList($data, 'items', fn ($value) => TransactionItem::from($value)),
            details: self::optional($data, 'details', fn ($value) => TransactionDetails::from($value)),
            payments: self::optionalList($data, 'payments', fn ($value) => TransactionPaymentAttempt::from($value)),
            checkout: self::optional($data, 'checkout', fn ($value) => Checkout::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            billedAt: self::optional($data, 'billed_at', fn ($value) => DateTime::from($value)),
            revisedAt: self::optional($data, 'revised_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'status' => $this->status,
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'custom_data' => $this->customData,
            'currency_code' => $this->currencyCode,
            'origin' => $this->origin,
            'subscription_id' => $this->subscriptionId,
            'invoice_id' => $this->invoiceId,
            'invoice_number' => $this->invoiceNumber,
            'collection_mode' => $this->collectionMode,
            'discount_id' => $this->discountId,
            'billing_details' => $this->billingDetails,
            'billing_period' => $this->billingPeriod,
            'items' => $this->items,
            'details' => $this->details,
            'payments' => $this->payments,
            'checkout' => $this->checkout,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'billed_at' => $this->billedAt,
            'revised_at' => $this->revisedAt,
        ]);
    }
}
