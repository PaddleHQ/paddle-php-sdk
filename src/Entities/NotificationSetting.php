<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Collections\EventTypeCollection;
use Paddle\SDK\Entities\NotificationSetting\NotificationSettingType;

class NotificationSetting implements Entity
{
    public function __construct(
        public string $id,
        public string $description,
        public NotificationSettingType $type,
        public string $destination,
        public bool $active,
        public int $apiVersion,
        public bool $includeSensitiveFields,
        public EventTypeCollection $subscribedEvents,
        public string $endpointSecretKey,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['description'],
            NotificationSettingType::from($data['type']),
            $data['destination'],
            $data['active'],
            $data['api_version'],
            $data['include_sensitive_fields'],
            EventTypeCollection::from($data['subscribed_events']),
            $data['endpoint_secret_key'],
        );
    }
}
