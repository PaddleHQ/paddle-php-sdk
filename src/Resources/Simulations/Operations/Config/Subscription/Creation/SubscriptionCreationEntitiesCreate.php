<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionCreationEntitiesCreate implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param SubscriptionCreationItemCreate[]|null $items
     */
    public function __construct(
        public readonly string|Undefined|null $customerId = new Undefined(),
        public readonly string|Undefined|null $addressId = new Undefined(),
        public readonly string|Undefined|null $businessId = new Undefined(),
        public readonly string|Undefined|null $paymentMethodId = new Undefined(),
        public readonly string|Undefined|null $discountId = new Undefined(),
        public readonly string|Undefined|null $transactionId = new Undefined(),
        public readonly array|Undefined|null $items = new Undefined(),
    ) {
        if (is_string($transactionId) && is_array($items)) {
            throw InvalidArgumentException::incompatibleArguments('transactionId', 'items');
        }
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'business_id' => $this->businessId,
            'payment_method_id' => $this->paymentMethodId,
            'discount_id' => $this->discountId,
            'transaction_id' => $this->transactionId,
            'items' => $this->items,
        ]);
    }
}
