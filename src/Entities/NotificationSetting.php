<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\NotificationSetting\NotificationSettingTrafficSource;
use Paddle\SDK\Entities\NotificationSetting\NotificationSettingType;

class NotificationSetting implements Entity
{
    /**
     * @param array<EventType> $subscribedEvents
     */
    private function __construct(
        public string $id,
        public string $description,
        public NotificationSettingType $type,
        public string $destination,
        public bool $active,
        public int $apiVersion,
        public bool $includeSensitiveFields,
        public array $subscribedEvents,
        public string $endpointSecretKey,
        public NotificationSettingTrafficSource $trafficSource,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            description: $data['description'],
            type: NotificationSettingType::from($data['type']),
            destination: $data['destination'],
            active: $data['active'],
            apiVersion: $data['api_version'],
            includeSensitiveFields: $data['include_sensitive_fields'],
            subscribedEvents: array_map(fn (array $eventType): EventType => EventType::from($eventType), $data['subscribed_events'] ?? []),
            endpointSecretKey: $data['endpoint_secret_key'],
            trafficSource: NotificationSettingTrafficSource::from($data['traffic_source']),
        );
    }
}
