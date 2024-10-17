<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations;

use Paddle\SDK\Entities\Simulation\SimulationStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListSimulations implements HasParameters
{
    /**
     * @param array<string>           $notificationSettingIds
     * @param array<string>           $ids
     * @param array<SimulationStatus> $statuses
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $notificationSettingIds = [],
        private readonly array $ids = [],
        private readonly array $statuses = [],
    ) {
        if ($invalid = array_filter($this->notificationSettingIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('notificationSettingIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof SimulationStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', SimulationStatus::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'notification_setting_id' => implode(',', $this->notificationSettingIds),
                'id' => implode(',', $this->ids),
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
            ]),
        );
    }
}
