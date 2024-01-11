<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Products;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Collections\ProductWithIncludesCollection;
use Paddle\SDK\Entities\ProductWithIncludes;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Products\Operations\CreateOperation;
use Paddle\SDK\Resources\Products\Operations\List\Includes;
use Paddle\SDK\Resources\Products\Operations\ListOperation;
use Paddle\SDK\Resources\Products\Operations\UpdateOperation;
use Paddle\SDK\ResponseParser;

class ProductsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListOperation $listOperation = new ListOperation()): ProductWithIncludesCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/products', $listOperation),
        );

        return ProductWithIncludesCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), ProductWithIncludesCollection::class),
        );
    }

    /**
     * @param array<Includes> $includes
     *
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id, array $includes = []): ProductWithIncludes
    {
        if ($invalid = array_filter($includes, fn ($value): bool => ! $value instanceof Includes)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('includes', Includes::class, implode(', ', $invalid));
        }

        $params = $includes === []
            ? []
            : ['include' => implode(',', array_map(fn ($enum) => $enum->value, $includes))];

        $parser = new ResponseParser(
            $this->client->getRaw("/products/{$id}", $params),
        );

        return ProductWithIncludes::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\ProductApiError On a product specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function create(CreateOperation $createOperation): ProductWithIncludes
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/products', $createOperation),
        );

        return ProductWithIncludes::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\ProductApiError On a product specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function update(string $id, UpdateOperation $operation): ProductWithIncludes
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/products/{$id}", $operation),
        );

        return ProductWithIncludes::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\ProductApiError On a product specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function archive(string $id): ProductWithIncludes
    {
        return $this->update($id, new UpdateOperation(status: Status::Archived));
    }
}
