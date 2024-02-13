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
use Paddle\SDK\Entities\Collections\ProductCollection;
use Paddle\SDK\Entities\Product;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Products\Operations\CreateProduct;
use Paddle\SDK\Resources\Products\Operations\List\Includes;
use Paddle\SDK\Resources\Products\Operations\ListProducts;
use Paddle\SDK\Resources\Products\Operations\UpdateProduct;
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
    public function list(ListProducts $listOperation = new ListProducts()): ProductCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/products', $listOperation),
        );

        return ProductCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), ProductCollection::class),
        );
    }

    /**
     * @param array<Includes> $includes
     *
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id, array $includes = []): Product
    {
        if ($invalid = array_filter($includes, fn ($value): bool => ! $value instanceof Includes)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('includes', Includes::class, implode(', ', $invalid));
        }

        $params = $includes === []
            ? []
            : ['include' => implode(',', array_map(fn ($enum) => $enum->getValue(), $includes))];

        $parser = new ResponseParser(
            $this->client->getRaw("/products/{$id}", $params),
        );

        return Product::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\ProductApiError On a product specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function create(CreateProduct $createOperation): Product
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/products', $createOperation),
        );

        return Product::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\ProductApiError On a product specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function update(string $id, UpdateProduct $operation): Product
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/products/{$id}", $operation),
        );

        return Product::from($parser->getData());
    }

    /**
     * @throws ApiError                 On a generic API error
     * @throws ApiError\ProductApiError On a product specific API error
     * @throws MalformedResponse        If the API response was not parsable
     */
    public function archive(string $id): Product
    {
        return $this->update($id, new UpdateProduct(status: Status::Archived()));
    }
}
