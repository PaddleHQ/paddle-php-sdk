<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class BillingDetails
{
    private function __construct(
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
}
