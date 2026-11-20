<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\IpAddresses;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\IpAddresses;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\ResponseParser;

class IpAddressesClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(): IpAddresses
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/ips'),
        );

        return IpAddresses::from($parser->getData());
    }
}
