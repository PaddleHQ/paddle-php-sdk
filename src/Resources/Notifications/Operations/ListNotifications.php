<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Notifications\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Notification\NotificationStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListNotifications implements HasParameters
{
    /**
     * @param array<string>             $notificationSettingIds
     * @param array<NotificationStatus> $statuses
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $notificationSettingIds = [],
        private readonly string|null $search = null,
        private readonly array $statuses = [],
        private readonly string|null $filter = null,
        private readonly \DateTimeInterface|null $to = null,
        private readonly \DateTimeInterface|null $from = null,
    ) {
        if ($invalid = array_filter($this->notificationSettingIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('notificationSettingIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof NotificationStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', NotificationStatus::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'notification_setting_id' => implode(',', $this->notificationSettingIds),
                'search' => $this->search,
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
                'filter' => $this->filter,
                'to' => isset($this->to) ? DateTime::from($this->to)?->format() : null,
                'from' => isset($this->from) ? DateTime::from($this->from)?->format() : null,
            ]),
        );
    }
}
