<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\SimulationRuns;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Collections\SimulationRunCollection;
use Paddle\SDK\Entities\SimulationRun;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\SimulationRuns\Operations\GetSimulationRuns;
use Paddle\SDK\Resources\SimulationRuns\Operations\ListSimulationRuns;
use Paddle\SDK\ResponseParser;

class SimulationRunsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(string $simulationId, ListSimulationRuns $listOperation = new ListSimulationRuns()): SimulationRunCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/simulations/{$simulationId}/runs", $listOperation),
        );

        return SimulationRunCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), SimulationRunCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $simulationId, string $id, GetSimulationRuns $getSimulationRuns = new GetSimulationRuns()): SimulationRun
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/simulations/{$simulationId}/runs/{$id}", $getSimulationRuns),
        );

        return SimulationRun::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function create(string $simulationId): SimulationRun
    {
        $parser = new ResponseParser(
            $this->client->postRaw("/simulations/{$simulationId}/runs"),
        );

        return SimulationRun::from($parser->getData());
    }
}
