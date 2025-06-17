<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\Simulation\SimulationStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Entity as NotificationEntity;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Undefined;

class UpdateSimulation implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $notificationSettingId = new Undefined(),
        public readonly EventTypeName|SimulationScenarioType|Undefined $type = new Undefined(),
        public readonly string|Undefined $name = new Undefined(),
        public readonly SimulationStatus|Undefined $status = new Undefined(),
        public readonly NotificationEntity|Undefined|null $payload = new Undefined(),
        public readonly SimulationConfigCreate|Undefined|null $config = new Undefined(),
    ) {
        if ($config instanceof SimulationConfigCreate && ! $config::getScenarioType()->equals($type)) {
            throw InvalidArgumentException::incompatibleArguments('config', 'type', (string) $type);
        }
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'notification_setting_id' => $this->notificationSettingId,
            'type' => $this->type,
            'name' => $this->name,
            'status' => $this->status,
            'payload' => $this->payload,
            'config' => $this->config,
        ]);
    }
}
