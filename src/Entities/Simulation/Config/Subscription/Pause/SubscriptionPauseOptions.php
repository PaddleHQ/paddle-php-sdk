<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Pause;

use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;

class SubscriptionPauseOptions
{
    private function __construct(
        public readonly SubscriptionEffectiveFrom $effectiveFrom,
        public readonly bool $hasPastDueTransactions,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            effectiveFrom: SubscriptionEffectiveFrom::from($data['effective_from']),
            hasPastDueTransactions: $data['has_past_due_transaction'],
        );
    }
}
