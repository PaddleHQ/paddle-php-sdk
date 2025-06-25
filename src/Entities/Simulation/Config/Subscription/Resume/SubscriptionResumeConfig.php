<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Resume;

class SubscriptionResumeConfig
{
    private function __construct(
        public readonly SubscriptionResumeEntities $entities,
        public readonly SubscriptionResumeOptions $options,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            entities: SubscriptionResumeEntities::from($data['entities']),
            options: SubscriptionResumeOptions::from($data['options']),
        );
    }
}
