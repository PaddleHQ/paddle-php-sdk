<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Creation;

use Paddle\SDK\Entities\Simulation\Config\Option\BusinessSimulatedAs;
use Paddle\SDK\Entities\Simulation\Config\Option\CustomerSimulatedAs;
use Paddle\SDK\Entities\Simulation\Config\Option\DiscountSimulatedAs;

class SubscriptionCreationOptions
{
    private function __construct(
        public readonly CustomerSimulatedAs $customerSimulatedAs,
        public readonly BusinessSimulatedAs $businessSimulatedAs,
        public readonly DiscountSimulatedAs $discountSimulatedAs,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            customerSimulatedAs: CustomerSimulatedAs::from($data['customer_simulated_as']),
            businessSimulatedAs: BusinessSimulatedAs::from($data['business_simulated_as']),
            discountSimulatedAs: DiscountSimulatedAs::from($data['discount_simulated_as']),
        );
    }
}
