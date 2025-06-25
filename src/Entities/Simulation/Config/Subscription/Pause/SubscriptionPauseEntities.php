<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Pause;

class SubscriptionPauseEntities
{
    private function __construct(
        public readonly string|null $subscriptionId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            subscriptionId: $data['subscription_id'],
        );
    }
}
