<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Simulations;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Collections\SimulationCollection;
use Paddle\SDK\Entities\Simulation;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Simulations\Operations\CreateSimulation;
use Paddle\SDK\Resources\Simulations\Operations\ListSimulations;
use Paddle\SDK\Resources\Simulations\Operations\UpdateSimulation;
use Paddle\SDK\ResponseParser;

class SimulationsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListSimulations $listOperation = new ListSimulations()): SimulationCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/simulations', $listOperation),
        );

        return SimulationCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), SimulationCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): Simulation
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/simulations/{$id}"),
        );

        return Simulation::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function create(CreateSimulation $createOperation): Simulation
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/simulations', $createOperation),
        );

        return Simulation::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function update(string $id, UpdateSimulation $operation): Simulation
    {
        $parser = new ResponseParser(
            $this->client->patchRaw("/simulations/{$id}", $operation),
        );

        return Simulation::from($parser->getData());
    }
}
