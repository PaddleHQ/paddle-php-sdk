<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations\Update;

use Paddle\SDK\Entities\Settings\CheckoutRecoveryDiscountType;

class CheckoutRecoveryDiscountUpdate implements \JsonSerializable
{
    public function __construct(
        public readonly CheckoutRecoveryDiscountType $type,
        public readonly string $amount,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'amount' => $this->amount,
        ];
    }
}
