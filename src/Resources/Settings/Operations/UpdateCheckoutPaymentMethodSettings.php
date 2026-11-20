<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\Resources\Settings\Operations\Update\CheckoutPaymentMethodsUpdate;

class UpdateCheckoutPaymentMethodSettings implements \JsonSerializable
{
    public function __construct(
        public readonly CheckoutPaymentMethodsUpdate $paymentMethods,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'payment_methods' => $this->paymentMethods,
        ];
    }
}
