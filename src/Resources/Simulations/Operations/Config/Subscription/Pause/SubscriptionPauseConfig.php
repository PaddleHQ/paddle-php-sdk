<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class SubscriptionPauseConfig implements SimulationConfigCreate
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionPauseEntities|Undefined $entities = new Undefined(),
        public readonly SubscriptionPauseOptions|Undefined $options = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'subscription_pause' => (object) $this->filterUndefined([
                'entities' => $this->entities,
                'options' => $this->options,
            ]),
        ];
    }
}
