<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations;

use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\Checkout;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\TransactionStatus;
use Paddle\SDK\Entities\Transaction\TransactionCreateItem as EntityTransactionCreateItem;
use Paddle\SDK\Entities\Transaction\TransactionCreateItemWithPrice as EntityTransactionCreateItemWithPrice;
use Paddle\SDK\Entities\Transaction\TransactionTimePeriod;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Transactions\Operations\Create\TransactionCreateItem;
use Paddle\SDK\Resources\Transactions\Operations\Create\TransactionCreateItemWithPrice;
use Paddle\SDK\Undefined;

class CreateTransaction implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<TransactionCreateItem|TransactionCreateItemWithPrice|EntityTransactionCreateItem|EntityTransactionCreateItemWithPrice> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly TransactionStatus|Undefined $status = new Undefined(),
        public readonly string|Undefined|null $customerId = new Undefined(),
        public readonly string|Undefined|null $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly CollectionMode|Undefined $collectionMode = new Undefined(),
        public readonly string|Undefined|null $discountId = new Undefined(),
        public readonly BillingDetails|Undefined|null $billingDetails = new Undefined(),
        public readonly TransactionTimePeriod|Undefined|null $billingPeriod = new Undefined(),
        public readonly Checkout|Undefined|null $checkout = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'items' => $this->items,
            'status' => $this->status,
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'custom_data' => $this->customData,
            'currency_code' => $this->currencyCode,
            'collection_mode' => $this->collectionMode,
            'discount_id' => $this->discountId,
            'billing_details' => $this->billingDetails,
            'billing_period' => $this->billingPeriod,
            'checkout' => $this->checkout,
        ]);
    }
}
