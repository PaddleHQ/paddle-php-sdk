<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations;

use Paddle\SDK\Entities\Shared\AddressPreview;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Transaction\TransactionItemPreviewWithNonCatalogPrice as EntityItemPreviewWithNonCatalogPrice;
use Paddle\SDK\Entities\Transaction\TransactionItemPreviewWithPriceId as EntityItemPreviewWithPriceId;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Transactions\Operations\Preview\TransactionItemPreviewWithNonCatalogPrice;
use Paddle\SDK\Resources\Transactions\Operations\Preview\TransactionItemPreviewWithPriceId;
use Paddle\SDK\Undefined;

class PreviewTransaction implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<TransactionItemPreviewWithPriceId|TransactionItemPreviewWithNonCatalogPrice|EntityItemPreviewWithPriceId|EntityItemPreviewWithNonCatalogPrice> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly string|Undefined|null $customerId = new Undefined(),
        public readonly string|Undefined|null $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly CollectionMode|Undefined $collectionMode = new Undefined(),
        public readonly string|Undefined|null $discountId = new Undefined(),
        public readonly string|Undefined|null $customerIpAddress = new Undefined(),
        public readonly AddressPreview|Undefined|null $address = new Undefined(),
        public readonly bool|Undefined $ignoreTrials = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'items' => $this->items,
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'currency_code' => $this->currencyCode,
            'collection_mode' => $this->collectionMode,
            'discount_id' => $this->discountId,
            'customer_ip_address' => $this->customerIpAddress,
            'address' => $this->address,
            'ignore_trials' => $this->ignoreTrials,
        ]);
    }
}
