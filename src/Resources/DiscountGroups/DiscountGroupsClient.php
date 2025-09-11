<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\DiscountGroups;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\DiscountGroupCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\DiscountGroup;
use Paddle\SDK\Entities\DiscountGroup\DiscountGroupStatus;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\DiscountGroups\Operations\CreateDiscountGroup;
use Paddle\SDK\Resources\DiscountGroups\Operations\ListDiscountGroups;
use Paddle\SDK\Resources\DiscountGroups\Operations\UpdateDiscountGroup;
use Paddle\SDK\ResponseParser;

class DiscountGroupsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListDiscountGroups $listOperation = new ListDiscountGroups()): DiscountGroupCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/discount-groups', $listOperation),
        );

        return DiscountGroupCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), DiscountGroupCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): DiscountGroup
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/discount-groups/{$id}"),
        );

        return DiscountGroup::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function create(CreateDiscountGroup $createOperation): DiscountGroup
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/discount-groups', $createOperation),
        );

        return DiscountGroup::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function update(string $id, UpdateDiscountGroup $updateOperation): DiscountGroup
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/discount-groups/{$id}", $updateOperation),
        );

        return DiscountGroup::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function archive(string $id): DiscountGroup
    {
        return $this->update($id, new UpdateDiscountGroup(status: DiscountGroupStatus::Archived()));
    }
}
