<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\NotificationSettings\Operations;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateNotificationSetting implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param EventTypeName[] $subscribedEvents
     */
    public function __construct(
        public readonly string|Undefined $description = new Undefined(),
        public readonly string|Undefined $destination = new Undefined(),
        public readonly bool|Undefined $active = new Undefined(),
        public readonly int|Undefined $apiVersion = new Undefined(),
        public readonly bool|Undefined $includeSensitiveFields = new Undefined(),
        public readonly array|Undefined $subscribedEvents = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'description' => $this->description,
            'destination' => $this->destination,
            'active' => $this->active,
            'api_version' => $this->apiVersion,
            'include_sensitive_fields' => $this->includeSensitiveFields,
            'subscribed_events' => $this->subscribedEvents,
        ]);
    }
}
