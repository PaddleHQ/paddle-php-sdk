<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\Entities\Entity;

class CheckoutPaymentMethodSettings implements Entity
{
    private function __construct(
        public CheckoutPaymentMethods $paymentMethods,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            paymentMethods: CheckoutPaymentMethods::from($data['payment_methods']),
        );
    }
}
