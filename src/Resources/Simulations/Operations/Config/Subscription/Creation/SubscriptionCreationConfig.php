<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class SubscriptionCreationConfig implements SimulationConfigCreate
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionCreationEntities|Undefined $entities = new Undefined(),
        public readonly SubscriptionCreationOptions|Undefined $options = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'subscription_creation' => (object) $this->filterUndefined([
                'entities' => $this->entities,
                'options' => $this->options,
            ]),
        ];
    }
}
