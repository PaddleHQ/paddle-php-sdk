<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Creation;

class SubscriptionCreationItem
{
    private function __construct(
        public readonly string $priceId,
        public readonly int $quantity,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            priceId: $data['price_id'],
            quantity: $data['quantity'],
        );
    }
}
