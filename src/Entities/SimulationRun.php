<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\Simulation\SimulationSingleEventType;
use Paddle\SDK\Entities\SimulationRun\SimulationRunStatus;

class SimulationRun implements Entity
{
    private function __construct(
        public string $id,
        public SimulationRunStatus $status,
        public SimulationSingleEventType|SimulationScenarioType $type,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: SimulationRunStatus::from($data['status']),
            type: SimulationSingleEventType::from($data['type'])->isKnown() ? SimulationSingleEventType::from($data['type']) : SimulationScenarioType::from($data['type']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
