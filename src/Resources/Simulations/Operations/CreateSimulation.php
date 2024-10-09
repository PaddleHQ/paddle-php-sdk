<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Entity as NotificationEntity;
use Paddle\SDK\Undefined;

class CreateSimulation implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string $notificationSettingId,
        public readonly EventTypeName|SimulationScenarioType $type,
        public readonly string $name,
        public readonly NotificationEntity|Undefined $payload = new Undefined(),
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
