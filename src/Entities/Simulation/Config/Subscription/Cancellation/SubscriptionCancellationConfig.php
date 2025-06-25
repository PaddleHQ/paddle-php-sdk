<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Cancellation;

class SubscriptionCancellationConfig
{
    private function __construct(
        public readonly SubscriptionCancellationEntities $entities,
        public readonly SubscriptionCancellationOptions $options,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entities: SubscriptionCancellationEntities::from($data['entities']),
            options: SubscriptionCancellationOptions::from($data['options']),
        );
    }
}
