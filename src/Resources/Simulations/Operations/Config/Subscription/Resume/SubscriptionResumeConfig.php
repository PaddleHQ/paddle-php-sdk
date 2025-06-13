<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Resume;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class SubscriptionResumeConfig implements SimulationConfigCreate
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionResumeEntities|Undefined $entities = new Undefined(),
        public readonly SubscriptionResumeOptions|Undefined $options = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'subscription_resume' => (object) $this->filterUndefined([
                'entities' => $this->entities,
                'options' => $this->options,
            ]),
        ];
    }
}
