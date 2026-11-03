<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Verifications;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\Paginator;
use Paddle\SDK\Entities\Collections\VerificationCollection;
use Paddle\SDK\Entities\Verification;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Verifications\Operations\ListVerifications;
use Paddle\SDK\ResponseParser;

class VerificationsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function list(ListVerifications $listOperation = new ListVerifications()): VerificationCollection
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/verifications', $listOperation),
        );

        return VerificationCollection::from(
            $parser->getData(),
            new Paginator($this->client, $parser->getPagination(), VerificationCollection::class),
        );
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function get(string $id): Verification
    {
        $parser = new ResponseParser(
            $this->client->getRaw("/verifications/{$id}"),
        );

        return Verification::from($parser->getData());
    }
}
