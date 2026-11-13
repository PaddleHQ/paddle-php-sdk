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
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\ApiKeys\Operations\CreateApiKeyRotation;
use Paddle\SDK\Resources\ApiKeys\Operations\ListApiKeyRotations;
use Paddle\SDK\Resources\ApiKeys\Operations\ListApiKeys;
use Paddle\SDK\ResponseParser;

class ApiKeysClient
{
    public function __construct(
        private readonly Client $client,
        private readonly string|null $currentApiKeyId = null,
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
     * Lists rotations of the API key this client is authenticated with. A key can only list its own rotations.
     *
     * @throws ApiError                 On a generic API error
     * @throws MalformedResponse        If the API response was not parsable
     * @throws InvalidArgumentException If the client's API key can't be rotated, such as a legacy API key
     */
    public function listRotationsForCurrentKey(ListApiKeyRotations $listOperation = new ListApiKeyRotations()): ApiKeyRotationCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/api-keys/{$this->currentApiKeyId()}/rotations", $listOperation),
        );

        return ApiKeyRotationCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), ApiKeyRotationCollection::class),
        );
    }

    /**
     * Gets a rotation of the API key this client is authenticated with. A key can only get its own rotations.
     *
     * @throws ApiError                 On a generic API error
     * @throws MalformedResponse        If the API response was not parsable
     * @throws InvalidArgumentException If the client's API key can't be rotated, such as a legacy API key
     */
    public function getRotationForCurrentKey(string $rotationId): ApiKeyRotation
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/api-keys/{$this->currentApiKeyId()}/rotations/{$rotationId}"),
        );

        return ApiKeyRotation::from($parser->getData());
    }

    /**
     * Rotates the API key this client is authenticated with. A key can only rotate itself.
     *
     * To rotate another key, create a client with that key's secret.
     *
     * @throws ApiError                 On a generic API error
     * @throws MalformedResponse        If the API response was not parsable
     * @throws InvalidArgumentException If the client's API key can't be rotated, such as a legacy API key
     */
    public function createRotationForCurrentKey(CreateApiKeyRotation $createOperation): ApiKeyRotationCreated
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/api-keys/{$this->currentApiKeyId()}/rotations", $createOperation),
        );

        return ApiKeyRotationCreated::from($parser->getData());
    }

    private function currentApiKeyId(): string
    {
        return $this->currentApiKeyId
            ?? throw new InvalidArgumentException("the client's API key can't be rotated, as it isn't a rotatable API key");
    }
}
