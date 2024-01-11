<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Addresses;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Address;
use Paddle\SDK\Entities\Collections\AddressCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Addresses\Operations\CreateOperation;
use Paddle\SDK\Resources\Addresses\Operations\ListOperation;
use Paddle\SDK\Resources\Addresses\Operations\UpdateOperation;
use Paddle\SDK\ResponseParser;

class AddressesClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(string $customerId, ListOperation $listOperation = new ListOperation()): AddressCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/customers/{$customerId}/addresses", $listOperation),
        );

        return AddressCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), AddressCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $customerId, string $id): Address
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/customers/{$customerId}/addresses/{$id}"),
        );

        return Address::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\AddressApiError On an address specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function create(string $customerId, CreateOperation $createOperation): Address
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/customers/{$customerId}/addresses", $createOperation),
        );

        return Address::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\AddressApiError On an address specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function update(string $customerId, string $id, UpdateOperation $operation): Address
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/customers/{$customerId}/addresses/{$id}", $operation),
        );

        return Address::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\AddressApiError On an address specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function archive(string $customerId, string $id): Address
    {
        return $this->update($customerId, $id, new UpdateOperation(status: Status::Archived));
    }
}
