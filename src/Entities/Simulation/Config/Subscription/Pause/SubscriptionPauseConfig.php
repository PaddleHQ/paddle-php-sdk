<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Pause;

class SubscriptionPauseConfig
{
    private function __construct(
        public readonly SubscriptionPauseEntities $entities,
        public readonly SubscriptionPauseOptions $options,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entities: SubscriptionPauseEntities::from($data['entities']),
            options: SubscriptionPauseOptions::from($data['options']),
        );
    }
}
