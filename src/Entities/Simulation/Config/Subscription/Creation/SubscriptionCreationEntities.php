<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Creation;

class SubscriptionCreationEntities
{
    /**
     * @param SubscriptionCreationItem[]|null $items
     */
    private function __construct(
        public readonly string|null $customerId,
        public readonly string|null $addressId,
        public readonly string|null $businessId,
        public readonly string|null $paymentMethodId,
        public readonly string|null $discountId,
        public readonly string|null $transactionId,
        public readonly array|null $items,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            customerId: $data['customer_id'],
            addressId: $data['address_id'],
            businessId: $data['business_id'],
            paymentMethodId: $data['payment_method_id'],
            discountId: $data['discount_id'],
            transactionId: $data['transaction_id'],
            items: isset($data['items'])
                ? array_map(
                    fn ($item) => SubscriptionCreationItem::from($item),
                    $data['items'],
                )
                : null,
        );
    }
}
