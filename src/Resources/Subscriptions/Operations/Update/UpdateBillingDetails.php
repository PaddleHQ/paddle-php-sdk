<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Update;

use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateBillingDetails implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly TimePeriod|Undefined $paymentTerms = new Undefined(),
        public readonly bool|Undefined $enableCheckout = new Undefined(),
        public readonly string|Undefined $purchaseOrderNumber = new Undefined(),
        public readonly string|Undefined|null $additionalInformation = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'enable_checkout' => $this->enableCheckout,
            'purchase_order_number' => $this->purchaseOrderNumber,
            'additional_information' => $this->additionalInformation,
            'payment_terms' => $this->paymentTerms,
        ]);
    }
}
