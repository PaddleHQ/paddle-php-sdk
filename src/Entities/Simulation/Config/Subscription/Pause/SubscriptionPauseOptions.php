<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Pause;

use Paddle\SDK\Entities\Simulation\Config\Option\EffectiveFrom;

class SubscriptionPauseOptions
{
    private function __construct(
        public readonly EffectiveFrom $effectiveFrom,
        public readonly bool $hasPastDueTransaction,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            effectiveFrom: EffectiveFrom::from($data['effective_from']),
            hasPastDueTransaction: $data['has_past_due_transaction'],
        );
    }
}
