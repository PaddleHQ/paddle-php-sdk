<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\EventTypes;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\EventTypeCollection;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\ResponseParser;

class EventTypesClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(): EventTypeCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/event-types'),
        );

        return EventTypeCollection::from($parser->getData());
    }
}
