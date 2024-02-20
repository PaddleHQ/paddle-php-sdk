<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\AddressPreview;
use Paddle\SDK\Entities\Shared\AvailablePaymentMethods;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\TransactionDetailsPreview;
use Paddle\SDK\Entities\Transaction\TransactionItemPreviewWithPrice;

class TransactionPreview implements Entity
{
    /**
     * @param array<TransactionItemPreviewWithPrice> $items
     * @param array<AvailablePaymentMethods>         $availablePaymentMethods
     */
    private function __construct(
        public string|null $customerId,
        public string|null $addressId,
        public string|null $businessId,
        public CurrencyCode $currencyCode,
        public string|null $discountId,
        public string|null $customerIpAddress,
        public AddressPreview|null $address,
        public bool $ignoreTrials,
        public array $items,
        public TransactionDetailsPreview $details,
        public array $availablePaymentMethods,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            customerId: $data['customer_id'] ?? null,
            addressId: $data['address_id'] ?? null,
            businessId: $data['business_id'] ?? null,
            currencyCode: CurrencyCode::from($data['currency_code']),
            discountId: $data['discount_id'] ?? null,
            customerIpAddress: $data['customer_ip_address'] ?? null,
            address: isset($data['address']) ? AddressPreview::from($data['address']) : null,
            ignoreTrials: $data['ignore_trials'],
            items: array_map(fn (array $item): TransactionItemPreviewWithPrice => TransactionItemPreviewWithPrice::from($item), $data['items']),
            details: TransactionDetailsPreview::from($data['details']),
            availablePaymentMethods: array_map(fn (string $item): AvailablePaymentMethods => AvailablePaymentMethods::from($item), $data['available_payment_methods']),
        );
    }
}
