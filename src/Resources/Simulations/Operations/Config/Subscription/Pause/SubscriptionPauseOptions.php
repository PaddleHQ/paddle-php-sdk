<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause;

use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionPauseOptions implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionEffectiveFrom|Undefined $effectiveFrom = new Undefined(),
        public readonly bool|Undefined $hasPastDueTransactions = new Undefined(),
    ) {
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'effective_from' => $this->effectiveFrom,
            'has_past_due_transaction' => $this->hasPastDueTransactions,
        ]);
    }
}
