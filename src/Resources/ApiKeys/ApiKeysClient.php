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
     * @throws ApiError                 On a generic API error
     * @throws MalformedResponse        If the API response was not parsable
     * @throws InvalidArgumentException If the key is the current one and the client's API key can't be rotated
     */
    public function listRotations(RotatableApiKey $apiKey, ListApiKeyRotations $listOperation = new ListApiKeyRotations()): ApiKeyRotationCollection
    {
        [$client, $apiKeyId] = $this->resolve($apiKey);

        $parser = new ResponseParser(
            $client->getRaw("/api-keys/{$apiKeyId}/rotations", $listOperation),
        );

        return ApiKeyRotationCollection::from(
            $parser->getData(),
            new Paginator($client, $parser->getPagination(), ApiKeyRotationCollection::class),
        );
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws MalformedResponse        If the API response was not parsable
     * @throws InvalidArgumentException If the key is the current one and the client's API key can't be rotated
     */
    public function getRotation(RotatableApiKey $apiKey, string $rotationId): ApiKeyRotation
    {
        [$client, $apiKeyId] = $this->resolve($apiKey);

        $parser = new ResponseParser(
            $client->getRaw("/api-keys/{$apiKeyId}/rotations/{$rotationId}"),
        );

        return ApiKeyRotation::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws MalformedResponse        If the API response was not parsable
     * @throws InvalidArgumentException If the key is the current one and the client's API key can't be rotated
     */
    public function createRotation(RotatableApiKey $apiKey, CreateApiKeyRotation $createOperation): ApiKeyRotationCreated
    {
        [$client, $apiKeyId] = $this->resolve($apiKey);

        $parser = new ResponseParser(
            $client->postRaw("/api-keys/{$apiKeyId}/rotations", $createOperation),
        );

        return ApiKeyRotationCreated::from($parser->getData());
    }

    /**
     * A key can only manage its own rotations, so another key's requests are authenticated with its secret.
     *
     * @return array{Client, string}
     */
    private function resolve(RotatableApiKey $apiKey): array
    {
        if ($apiKey->isCurrent()) {
            if ($this->currentApiKeyId === null) {
                throw new InvalidArgumentException("the client's API key can't be rotated, as it isn't a rotatable API key");
            }

            return [$this->client, $this->currentApiKeyId];
        }

        return [$this->client->withApiKey((string) $apiKey->secret()), (string) $apiKey->id];
    }
}
