<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Cancellation;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class SubscriptionCancellationConfigCreate implements SimulationConfigCreate
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionCancellationEntitiesCreate|Undefined $entities = new Undefined(),
        public readonly SubscriptionCancellationOptionsCreate|Undefined $options = new Undefined(),
    ) {
    }

    public static function getScenarioType(): SimulationScenarioType
    {
        return SimulationScenarioType::SubscriptionCancellation();
    }

    public function jsonSerialize(): array
    {
        return [
            'subscription_cancellation' => (object) $this->filterUndefined([
                'entities' => $this->entities,
                'options' => $this->options,
            ]),
        ];
    }
}
