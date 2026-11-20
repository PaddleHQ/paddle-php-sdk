<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\ApiRoot;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\RootContext;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\ResponseParser;

class ApiRootClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(): RootContext
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/'),
        );

        return RootContext::from($parser->getData());
    }
}
