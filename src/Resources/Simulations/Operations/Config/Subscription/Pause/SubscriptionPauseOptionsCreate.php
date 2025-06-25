<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause;

use Paddle\SDK\Entities\Simulation\Config\Option\EffectiveFrom;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionPauseOptionsCreate implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly EffectiveFrom|Undefined $effectiveFrom = new Undefined(),
        public readonly bool|Undefined $hasPastDueTransaction = new Undefined(),
    ) {
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'effective_from' => $this->effectiveFrom,
            'has_past_due_transaction' => $this->hasPastDueTransaction,
        ]);
    }
}
