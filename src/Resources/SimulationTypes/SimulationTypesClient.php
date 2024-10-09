<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\SimulationTypes;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\SimulationTypeCollection;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\ResponseParser;

class SimulationTypesClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(): SimulationTypeCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/simulation-types'),
        );

        return SimulationTypeCollection::from($parser->getData());
    }
}
