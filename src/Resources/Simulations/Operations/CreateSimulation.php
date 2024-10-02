<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations;

use Paddle\SDK\Entities\Shared\JSONObject;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\Simulation\SimulationSingleEventType;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateSimulation implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string $notificationSettingId,
        public readonly SimulationSingleEventType|SimulationScenarioType $type,
        public readonly string $name,
        public readonly JSONObject|Undefined $payload = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'notification_setting_id' => $this->notificationSettingId,
            'type' => $this->type,
            'name' => $this->name,
            'payload' => $this->payload,
        ]);
    }
}
