<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Account;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\AccountDetails;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Account\Operations\UpdateAccount;
use Paddle\SDK\ResponseParser;

class AccountClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(): AccountDetails
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/account'),
        );

        return AccountDetails::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function update(UpdateAccount $operation): AccountDetails
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/account', $operation),
        );

        return AccountDetails::from($parser->getData());
    }
}
