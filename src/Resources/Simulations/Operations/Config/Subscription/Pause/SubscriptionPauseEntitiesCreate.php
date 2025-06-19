<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionPauseEntitiesCreate implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined|null $subscriptionId = new Undefined(),
    ) {
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'subscription_id' => $this->subscriptionId,
        ]);
    }
}
