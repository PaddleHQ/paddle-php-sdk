<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\PricingPreviews\Operations;

use Paddle\SDK\Entities\PricingPreview\PricePreviewItem;
use Paddle\SDK\Entities\Shared\AddressPreview;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class PreviewPrice implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param PricePreviewItem[] $items
     */
    public function __construct(
        public readonly array $items,
        public readonly string|Undefined|null $customerId = new Undefined(),
        public readonly string|Undefined|null $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly string|Undefined|null $discountId = new Undefined(),
        public readonly AddressPreview|Undefined|null $address = new Undefined(),
        public readonly string|Undefined|null $customerIpAddress = new Undefined(),
    ) {
        if ($this->items === []) {
            throw InvalidArgumentException::arrayIsEmpty('items');
        }

        if ($invalid = array_filter($this->items, fn ($value): bool => ! $value instanceof PricePreviewItem)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('items', PricePreviewItem::class, implode(', ', $invalid));
        }
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'items' => $this->items,
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'currency_code' => $this->currencyCode,
            'discount_id' => $this->discountId,
            'address' => $this->address,
            'customer_ip_address' => $this->customerIpAddress,
        ]);
    }
}
