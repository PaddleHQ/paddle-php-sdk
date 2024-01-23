<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\NotificationLogs;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\NotificationLogCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\NotificationLogs\Operations\ListNotificationLogs;
use Paddle\SDK\ResponseParser;

class NotificationLogsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(string $notificationId, ListNotificationLogs $listOperation = new ListNotificationLogs()): NotificationLogCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/notifications/{$notificationId}/logs", $listOperation),
        );

        return NotificationLogCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), NotificationLogCollection::class),
        );
    }
}
