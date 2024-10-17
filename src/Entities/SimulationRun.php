<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\SimulationRun\SimulationRunStatus;

class SimulationRun implements Entity
{
    /**
     * @param array<SimulationRunEvent> $events
     */
    private function __construct(
        public string $id,
        public SimulationRunStatus $status,
        public EventTypeName|SimulationScenarioType $type,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public array $events,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: SimulationRunStatus::from($data['status']),
            type: EventTypeName::from($data['type'])->isKnown() ? EventTypeName::from($data['type']) : SimulationScenarioType::from($data['type']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            events: array_map(fn (array $event): SimulationRunEvent => SimulationRunEvent::from($event), $data['events'] ?? []),
        );
    }
}
