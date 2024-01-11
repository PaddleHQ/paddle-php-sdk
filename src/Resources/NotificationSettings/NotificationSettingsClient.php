<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\NotificationSettings;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\NotificationSettingCollection;
use Paddle\SDK\Entities\NotificationSetting;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\NotificationSettings\Operations\CreateNotificationSetting;
use Paddle\SDK\Resources\NotificationSettings\Operations\UpdateNotificationSetting;
use Paddle\SDK\ResponseParser;

class NotificationSettingsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(): NotificationSettingCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('notification-settings'),
        );

        return NotificationSettingCollection::from(
            $parser->getData(),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): NotificationSetting
    {
        $parser = new ResponseParser(
            $this->client->getRaw("notification-settings/{$id}"),
        );

        return NotificationSetting::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function create(CreateNotificationSetting $createOperation): NotificationSetting
    {
        $parser = new ResponseParser(
            $this->client->postRaw('notification-settings', $createOperation),
        );

        return NotificationSetting::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function update(string $id, UpdateNotificationSetting $operation): NotificationSetting
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("notification-settings/{$id}", $operation),
        );

        return NotificationSetting::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function delete(string $id): void
    {
        new ResponseParser($this->client->deleteRaw("notification-settings/{$id}"));
    }
}
