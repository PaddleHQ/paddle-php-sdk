<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Creation;

class SubscriptionCreationConfig
{
    private function __construct(
        public readonly SubscriptionCreationEntities $entities,
        public readonly SubscriptionCreationOptions $options,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entities: SubscriptionCreationEntities::from($data['entities']),
            options: SubscriptionCreationOptions::from($data['options']),
        );
    }
}
