<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class SubscriptionRenewalConfig implements SimulationConfigCreate
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionRenewalEntities|Undefined $entities = new Undefined(),
        public readonly SubscriptionRenewalOptions|Undefined $options = new Undefined(),
    ) {
    }

    public static function getScenarioType(): SimulationScenarioType
    {
        return SimulationScenarioType::SubscriptionRenewal();
    }

    public function jsonSerialize(): array
    {
        return [
            'subscription_renewal' => (object) $this->filterUndefined([
                'entities' => $this->entities,
                'options' => $this->options,
            ]),
        ];
    }
}
