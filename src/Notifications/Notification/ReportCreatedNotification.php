<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Notification;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Report;
use Paddle\SDK\Notifications\Events\ReportCreated;
use Paddle\SDK\Notifications\Notification;

final class ReportCreatedNotification extends Notification
{
    public readonly Report $report;

    private function __construct(string $id, ReportCreated $event)
    {
        $this->report = $event->report;

        parent::__construct($id, $event);
    }

    /**
     * @param ReportCreated $event
     */
    protected static function fromEvent(string $id, Event $event): static
    {
        return new self($id, $event);
    }
}
