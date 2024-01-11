<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\PricingPreviews\Operations;

use Paddle\SDK\Entities\PricingPreview\PricePreviewItem;
use Paddle\SDK\Entities\Shared\AddressPreview;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class PreviewPricesOperation implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param PricePreviewItem[] $items
     */
    public function __construct(
        public readonly array $items,
        public readonly string|null|Undefined $customerId = new Undefined(),
        public readonly string|null|Undefined $addressId = new Undefined(),
        public readonly string|null|Undefined $businessId = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly string|null|Undefined $discountId = new Undefined(),
        public readonly AddressPreview|null|Undefined $address = new Undefined(),
        public readonly string|null|Undefined $customerIpAddress = new Undefined(),
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
            'discount_id' => $this->discountId,
            'address' => $this->address,
            'customer_ip_address' => $this->customerIpAddress,
        ]);
    }
}
