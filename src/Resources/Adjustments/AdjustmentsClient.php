<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Adjustments;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Adjustment;
use Paddle\SDK\Entities\Collections\AdjustmentsAdjustmentCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Adjustments\Operations\CreateOperation;
use Paddle\SDK\Resources\Adjustments\Operations\ListOperation;
use Paddle\SDK\ResponseParser;

class AdjustmentsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListOperation $listOperation = new ListOperation()): AdjustmentsAdjustmentCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/adjustments', $listOperation),
        );

        return AdjustmentsAdjustmentCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), AdjustmentsAdjustmentCollection::class),
        );
    }

    /**
     * @throws ApiError                    On a generic API error
     * @throws ApiError\AdjustmentApiError On an adjustment specific API error
     * @throws MalformedResponse           If the API response was not parsable
     */
    public function create(CreateOperation $createOperation): Adjustment
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/adjustments', $createOperation),
        );

        return Adjustment::from($parser->getData());
    }
}
