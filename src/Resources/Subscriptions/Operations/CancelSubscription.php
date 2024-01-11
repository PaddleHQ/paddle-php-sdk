<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;

class CancelSubscription implements \JsonSerializable
{
    public function __construct(
        public readonly SubscriptionEffectiveFrom|null $effectiveFrom = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'effective_from' => $this->effectiveFrom,
        ];
    }
}
