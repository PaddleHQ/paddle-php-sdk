<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\ApiKeys;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\ApiKey;
use Paddle\SDK\Entities\ApiKeyRotation;
use Paddle\SDK\Entities\ApiKeyRotationCreated;
use Paddle\SDK\Entities\Collections\ApiKeyCollection;
use Paddle\SDK\Entities\Collections\ApiKeyRotationCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\ApiKeys\Operations\CreateApiKeyRotation;
use Paddle\SDK\Resources\ApiKeys\Operations\ListApiKeyRotations;
use Paddle\SDK\Resources\ApiKeys\Operations\ListApiKeys;
use Paddle\SDK\ResponseParser;

class ApiKeysClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListApiKeys $listOperation = new ListApiKeys()): ApiKeyCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/api-keys', $listOperation),
        );

        return ApiKeyCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), ApiKeyCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): ApiKey
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/api-keys/{$id}"),
        );

        return ApiKey::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function listRotations(string $apiKeyId, ListApiKeyRotations $listOperation = new ListApiKeyRotations()): ApiKeyRotationCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/api-keys/{$apiKeyId}/rotations", $listOperation),
        );

        return ApiKeyRotationCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), ApiKeyRotationCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getRotation(string $apiKeyId, string $rotationId): ApiKeyRotation
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/api-keys/{$apiKeyId}/rotations/{$rotationId}"),
        );

        return ApiKeyRotation::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function createRotation(string $apiKeyId, CreateApiKeyRotation $createOperation): ApiKeyRotationCreated
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/api-keys/{$apiKeyId}/rotations", $createOperation),
        );

        return ApiKeyRotationCreated::from($parser->getData());
    }
}
