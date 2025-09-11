<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Events\Operations;

use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListEvents implements HasParameters
{
    /**
     * @param array<EventTypeName> $eventTypes
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $eventTypes = [],
    ) {
        if ($invalid = array_filter($this->eventTypes, fn ($value): bool => ! $value instanceof EventTypeName)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('eventTypes', EventTypeName::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'event_type' => implode(',', array_map($enumStringify, $this->eventTypes)),
            ]),
        );
    }
}
