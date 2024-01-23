<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Events;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\EventCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Events\Operations\ListEvents;
use Paddle\SDK\ResponseParser;

class EventsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListEvents $listOperation = new ListEvents()): EventCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/events', $listOperation),
        );

        return EventCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), EventCollection::class),
        );
    }
}
