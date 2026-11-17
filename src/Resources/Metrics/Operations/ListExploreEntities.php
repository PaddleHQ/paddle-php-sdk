<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Metrics\Operations;

use Paddle\SDK\Entities\Metrics\MetricEntity;
use Paddle\SDK\HasParameters;

class ListExploreEntities implements HasParameters
{
    public function __construct(
        private readonly MetricEntity|null $entity = null,
    ) {
    }

    public function getParameters(): array
    {
        return $this->entity === null ? [] : ['entity' => $this->entity->getValue()];
    }
}
