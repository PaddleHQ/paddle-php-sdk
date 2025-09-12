<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\ClientTokens;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\ClientToken;
use Paddle\SDK\Entities\ClientToken\ClientTokenStatus;
use Paddle\SDK\Entities\Collections\ClientTokenCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\ClientTokens\Operations\CreateClientToken;
use Paddle\SDK\Resources\ClientTokens\Operations\ListClientTokens;
use Paddle\SDK\Resources\ClientTokens\Operations\UpdateClientToken;
use Paddle\SDK\ResponseParser;

class ClientTokensClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListClientTokens $listOperation = new ListClientTokens()): ClientTokenCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/client-tokens', $listOperation),
        );

        return ClientTokenCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), ClientTokenCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): ClientToken
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/client-tokens/{$id}"),
        );

        return ClientToken::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function create(CreateClientToken $createOperation): ClientToken
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/client-tokens', $createOperation),
        );

        return ClientToken::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function update(string $id, UpdateClientToken $operation): ClientToken
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/client-tokens/{$id}", $operation),
        );

        return ClientToken::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function revoke(string $id): ClientToken
    {
        return $this->update($id, new UpdateClientToken(status: ClientTokenStatus::Revoked()));
    }
}
