<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\SimulationRunEvent\SimulationRunEventRequest;
use Paddle\SDK\Entities\SimulationRunEvent\SimulationRunEventResponse;
use Paddle\SDK\Entities\SimulationRunEvent\SimulationRunEventStatus;
use Paddle\SDK\Notifications\Entities\Entity as NotificationEntity;
use Paddle\SDK\Notifications\Entities\EntityFactory;

class SimulationRunEvent implements Entity
{
    private function __construct(
        public string $id,
        public SimulationRunEventStatus $status,
        public EventTypeName $type,
        public NotificationEntity $payload,
        public SimulationRunEventRequest|null $request,
        public SimulationRunEventResponse|null $response,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: SimulationRunEventStatus::from($data['status']),
            type: EventTypeName::from($data['event_type']),
            payload: $data['payload'] ? EntityFactory::create($data['event_type'], $data['payload']) : null,
            request: isset($data['request']) ? SimulationRunEventRequest::from($data['request']) : null,
            response: isset($data['response']) ? SimulationRunEventResponse::from($data['response']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
