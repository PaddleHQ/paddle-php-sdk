<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\CustomerPortalSessions;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\CustomerPortalSession;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\CustomerPortalSessions\Operations\CreateCustomerPortalSession;
use Paddle\SDK\ResponseParser;

class CustomerPortalSessionsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function create(string $customerId, CreateCustomerPortalSession $createOperation): CustomerPortalSession
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/customers/{$customerId}/portal-sessions", $createOperation),
        );

        return CustomerPortalSession::from($parser->getData());
    }
}
