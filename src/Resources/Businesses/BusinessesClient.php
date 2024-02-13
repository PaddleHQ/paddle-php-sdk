<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Businesses;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Business;
use Paddle\SDK\Entities\Collections\BusinessCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Businesses\Operations\CreateBusiness;
use Paddle\SDK\Resources\Businesses\Operations\ListBusinesses;
use Paddle\SDK\Resources\Businesses\Operations\UpdateBusiness;
use Paddle\SDK\ResponseParser;

class BusinessesClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(string $customerId, ListBusinesses $listOperation = new ListBusinesses()): BusinessCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/customers/{$customerId}/businesses", $listOperation),
        );

        return BusinessCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), BusinessCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $customerId, string $id): Business
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/customers/{$customerId}/businesses/{$id}"),
        );

        return Business::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\BusinessApiError On an business specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function create(string $customerId, CreateBusiness $createOperation): Business
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/customers/{$customerId}/businesses", $createOperation),
        );

        return Business::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\BusinessApiError On an business specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function update(string $customerId, string $id, UpdateBusiness $operation): Business
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/customers/{$customerId}/businesses/{$id}", $operation),
        );

        return Business::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\BusinessApiError On an business specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function archive(string $customerId, string $id): Business
    {
        return $this->update($customerId, $id, new UpdateBusiness(status: Status::Archived()));
    }
}
