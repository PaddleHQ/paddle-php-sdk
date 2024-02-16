<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class BillingDetailsUpdate
{
    private function __construct(
        public bool $enableCheckout,
        public string $purchaseOrderNumber,
        public string $additionalInformation,
        public TimePeriod $paymentTerms,
    ) {
    }
}
