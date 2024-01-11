<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Notifications\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Notification\NotificationStatus;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListOperation implements HasParameters
{
    /**
     * @param array<string>             $notificationSettingId
     * @param array<NotificationStatus> $status
     */
    public function __construct(
        private readonly ?Pager $pager = null,
        private readonly array $notificationSettingId = [],
        private readonly string|null $search = null,
        private readonly array $status = [],
        private readonly string|null $filter = null,
        private readonly \DateTimeInterface|null $to = null,
        private readonly \DateTimeInterface|null $from = null,
    ) {
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->value;

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'notification_setting_id' => implode(',', $this->notificationSettingId),
                'search' => $this->search,
                'status' => implode(',', array_map($enumStringify, $this->status)),
                'filter' => $this->filter,
                'to' => isset($this->to) ? DateTime::from($this->to)?->format() : null,
                'from' => isset($this->from) ? DateTime::from($this->from)?->format() : null,
            ]),
        );
    }
}
