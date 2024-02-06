<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\NotificationLogs\Operations;

use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListNotificationLogs implements HasParameters
{
    public function __construct(private readonly Pager|null $pager = null)
    {
    }

    public function getParameters(): array
    {
        return $this->pager?->getParameters() ?? [];
    }
}
