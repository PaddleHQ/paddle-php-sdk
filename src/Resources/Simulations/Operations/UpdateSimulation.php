<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations;

use Paddle\SDK\Entities\Shared\JSONObject;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\Simulation\SimulationSingleEventType;
use Paddle\SDK\Entities\Simulation\SimulationStatus;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateSimulation implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $notificationSettingId = new Undefined(),
        public readonly SimulationSingleEventType|SimulationScenarioType|Undefined $type = new Undefined(),
        public readonly string|Undefined $name = new Undefined(),
        public readonly SimulationStatus|Undefined $status = new Undefined(),
        public readonly JSONObject|Undefined $payload = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'notification_setting_id' => $this->notificationSettingId,
            'type' => $this->type,
            'name' => $this->name,
            'status' => $this->status,
            'payload' => $this->payload,
        ]);
    }
}