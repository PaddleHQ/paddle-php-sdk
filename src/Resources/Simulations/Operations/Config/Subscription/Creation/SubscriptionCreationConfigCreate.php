<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class SubscriptionCreationConfigCreate implements SimulationConfigCreate
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionCreationEntitiesCreate|Undefined $entities = new Undefined(),
        public readonly SubscriptionCreationOptionsCreate|Undefined $options = new Undefined(),
    ) {
    }

    public static function getScenarioType(): SimulationScenarioType
    {
        return SimulationScenarioType::SubscriptionCreation();
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
