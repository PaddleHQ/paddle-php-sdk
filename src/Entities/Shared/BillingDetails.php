<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class BillingDetails implements \JsonSerializable
{
    public function __construct(
        public bool $enableCheckout,
        public TimePeriod $paymentTerms,
        public string|null $purchaseOrderNumber = null,
        public string|null $additionalInformation = null,
    ) {
    }

    public static function from(array $billingDetails): self
    {
        return new self(
            $billingDetails['enable_checkout'],
            TimePeriod::from($billingDetails['payment_terms']),
            $billingDetails['purchase_order_number'],
            $billingDetails['additional_information'],
        );
    }

    public function jsonSerialize(): array
    {
        // The API rejects null for the optional strings, so they are left out instead.
        return array_filter(
            [
                'enable_checkout' => $this->enableCheckout,
                'payment_terms' => $this->paymentTerms,
                'purchase_order_number' => $this->purchaseOrderNumber,
                'additional_information' => $this->additionalInformation,
            ],
            fn ($value): bool => $value !== null,
        );
    }
}
