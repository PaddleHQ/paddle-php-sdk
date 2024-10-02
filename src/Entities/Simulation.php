<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\JSONObject;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\Simulation\SimulationSingleEventType;
use Paddle\SDK\Entities\Simulation\SimulationStatus;

class Simulation implements Entity
{
    private function __construct(
        public string $id,
        public SimulationStatus $status,
        public string $notificationSettingId,
        public string $name,
        public SimulationSingleEventType|SimulationScenarioType $type,
        public JSONObject|null $payload,
        public \DateTimeInterface|null $lastRunAt,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: SimulationStatus::from($data['status']),
            notificationSettingId: $data['notification_setting_id'],
            name: $data['name'],
            type: SimulationSingleEventType::from($data['type'])->isKnown() ? SimulationSingleEventType::from($data['type']) : SimulationScenarioType::from($data['type']),
            payload: $data['payload'] ? new JSONObject($data['payload']) : null,
            lastRunAt: isset($data['last_run_at']) ? DateTime::from($data['last_run_at']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
