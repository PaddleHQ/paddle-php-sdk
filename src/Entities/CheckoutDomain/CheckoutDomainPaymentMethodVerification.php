<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\CheckoutDomain;

class CheckoutDomainPaymentMethodVerification
{
    private function __construct(
        public readonly CheckoutDomainApplePayVerification $applePay,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            applePay: CheckoutDomainApplePayVerification::from($data['apple_pay']),
        );
    }
}
