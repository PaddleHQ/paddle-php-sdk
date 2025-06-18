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
use Paddle\SDK\Entities\AdjustmentCreditNote;
use Paddle\SDK\Entities\Collections\AdjustmentCollection;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Adjustments\Operations\CreateAdjustment;
use Paddle\SDK\Resources\Adjustments\Operations\GetAdjustmentCreditNote;
use Paddle\SDK\Resources\Adjustments\Operations\ListAdjustments;
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
    public function list(ListAdjustments $listOperation = new ListAdjustments()): AdjustmentCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/adjustments', $listOperation),
        );

        return AdjustmentCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), AdjustmentCollection::class),
        );
    }

    /**
     * @throws ApiError                    On a generic API error
     * @throws ApiError\AdjustmentApiError On an adjustment specific API error
     * @throws MalformedResponse           If the API response was not parsable
     */
    public function create(CreateAdjustment $createOperation): Adjustment
    {
        $parser = new ResponseParser(
            $this->client->postRaw('/adjustments', $createOperation),
        );

        return Adjustment::from($parser->getData());
    }

    /**
     * @throws ApiError                    On a generic API error
     * @throws ApiError\AdjustmentApiError On an adjustment specific API error
     * @throws MalformedResponse           If the API response was not parsable
     */
    public function getCreditNote(string $id, GetAdjustmentCreditNote $getOperation = new GetAdjustmentCreditNote()): AdjustmentCreditNote
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/adjustments/{$id}/credit-note", $getOperation),
        );

        return AdjustmentCreditNote::from($parser->getData());
    }
}
