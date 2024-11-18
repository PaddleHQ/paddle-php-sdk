<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Customers;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\CreditBalanceCollection;
use Paddle\SDK\Entities\Collections\CustomerCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Customer;
use Paddle\SDK\Entities\CustomerAuthToken;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Customers\Operations\CreateCustomer;
use Paddle\SDK\Resources\Customers\Operations\ListCreditBalances;
use Paddle\SDK\Resources\Customers\Operations\ListCustomers;
use Paddle\SDK\Resources\Customers\Operations\UpdateCustomer;
use Paddle\SDK\ResponseParser;

class CustomersClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListCustomers $listOperation = new ListCustomers()): CustomerCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/customers', $listOperation),
        );

        return CustomerCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), CustomerCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): Customer
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/customers/{$id}"),
        );

        return Customer::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\CustomerApiError On a customer specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function create(CreateCustomer $createOperation): Customer
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/customers', $createOperation),
        );

        return Customer::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\CustomerApiError On a customer specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function update(string $id, UpdateCustomer $operation): Customer
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/customers/{$id}", $operation),
        );

        return Customer::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\CustomerApiError On a customer specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function archive(string $id): Customer
    {
        return $this->update($id, new UpdateCustomer(status: Status::Archived()));
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\CustomerApiError On a customer specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function creditBalances(string $id, ListCreditBalances $operation = new ListCreditBalances()): CreditBalanceCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/customers/{$id}/credit-balances", $operation),
        );

        return CreditBalanceCollection::from($parser->getData());
    }

    /**
     * @throws ApiError                  On a generic API error
     * @throws ApiError\CustomerApiError On a customer specific API error
     * @throws MalformedResponse         If the API response was not parsable
     */
    public function generateAuthToken(string $id): CustomerAuthToken
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/customers/{$id}/auth-token", null),
        );

        return CustomerAuthToken::from($parser->getData());
    }
}
