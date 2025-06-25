<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Renewal;

class SubscriptionRenewalConfig
{
    private function __construct(
        public readonly SubscriptionRenewalEntities $entities,
        public readonly SubscriptionRenewalOptions $options,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entities: SubscriptionRenewalEntities::from($data['entities']),
            options: SubscriptionRenewalOptions::from($data['options']),
        );
    }
}
