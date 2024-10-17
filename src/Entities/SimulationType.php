<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\Simulation\SimulationKind;

class SimulationType implements Entity
{
    private function __construct(
        public string $name,
        public string $label,
        public string $description,
        public string $group,
        public SimulationKind $type,
        public array $events,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            label: $data['label'],
            description: $data['description'],
            group: $data['group'],
            type: SimulationKind::from($data['type']),
            events: array_map(fn (string $event): EventTypeName => EventTypeName::from($event), $data['events']),
        );
    }
}
