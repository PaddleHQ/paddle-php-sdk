<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\CheckoutDomains;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\CheckoutDomain;
use Paddle\SDK\Entities\Collections\CheckoutDomainCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\CheckoutDomains\Operations\ListCheckoutDomains;
use Paddle\SDK\Resources\CheckoutDomains\Operations\VerifyPaymentMethod;
use Paddle\SDK\ResponseParser;

class CheckoutDomainsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListCheckoutDomains $listOperation = new ListCheckoutDomains()): CheckoutDomainCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/checkout-domains', $listOperation),
        );

        return CheckoutDomainCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), CheckoutDomainCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): CheckoutDomain
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/checkout-domains/{$id}"),
        );

        return CheckoutDomain::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function delete(string $id): void
    {
        new ResponseParser($this->client->deleteRaw("/checkout-domains/{$id}"));
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function verifyPaymentMethod(string $id, VerifyPaymentMethod $verifyOperation): CheckoutDomain
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/checkout-domains/{$id}/verify-payment-method", $verifyOperation),
        );

        return CheckoutDomain::from($parser->getData());
    }
}
