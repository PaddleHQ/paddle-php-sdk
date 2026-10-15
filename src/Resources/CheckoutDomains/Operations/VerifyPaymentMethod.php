<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\CheckoutDomains\Operations;

use Paddle\SDK\Entities\CheckoutDomain\CheckoutDomainPaymentMethod;

class VerifyPaymentMethod implements \JsonSerializable
{
    public function __construct(
        public readonly CheckoutDomainPaymentMethod $paymentMethod,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'payment_method' => $this->paymentMethod,
        ];
    }
}
