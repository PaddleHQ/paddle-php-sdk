<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\PricingPreview\PricePreviewDetails;
use Paddle\SDK\Entities\Shared\AddressPreview;
use Paddle\SDK\Entities\Shared\AvailablePaymentMethods;
use Paddle\SDK\Entities\Shared\CurrencyCode;

class PricePreview implements Entity
{
    /**
     * @param array<AvailablePaymentMethods> $availablePaymentMethods
     */
    private function __construct(
        public string|null $customerId,
        public string|null $addressId,
        public string|null $businessId,
        public CurrencyCode $currencyCode,
        public string|null $discountId,
        public AddressPreview|null $address,
        public string|null $customerIpAddress,
        public PricePreviewDetails $details,
        public array $availablePaymentMethods,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['customer_id'] ?? null,
            $data['address_id'] ?? null,
            $data['business_id'] ?? null,
            CurrencyCode::from($data['currency_code']),
            $data['discount_id'] ?? null,
            isset($data['address']) ? AddressPreview::from($data['address']) : null,
            $data['customer_ip_address'] ?? null,
            PricePreviewDetails::from($data['details']),
            availablePaymentMethods: array_map(fn (string $item): AvailablePaymentMethods => AvailablePaymentMethods::from($item), $data['available_payment_methods']),
        );
    }
}
