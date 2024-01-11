<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Notifications;

use Http\Discovery\Psr17FactoryDiscovery;
use Paddle\SDK\Notifications\PaddleSignature;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;
use PHPUnit\Framework\TestCase;

class VerifierTest extends TestCase
{
    /** @test */
    public function it_verifies_a_signature(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '/paddle/notifications')
            ->withHeader(
                PaddleSignature::HEADER,
                'ts=1696195954;h1=dummy;h1=d96299976a6eb066f484d7fde011ac56fc32b38fc9940bc419d6e537fdc6ef02',
            )
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream('hello-world'),
            );

        $secrets = [
            new Secret('pdl_ntf_01hbpjmytsa32fhr36nqgc3kgb_TjIG2BXbm83HPXqNfziwe506sBEdqL/4'),
            new Secret('pdl_ntf_01hbpjmytsa32fhr36nqgc3kgb_vB/yIOnTOCWIvpBadM5jzBZPHc7OmdSo'),
            // The correct key
            new Secret('pdl_ntf_01hbpjmytsa32fhr36nqgc3kgb_WvRO0eL4Bj9rgYYIBZY6wZhG4EHy9jzh'),
        ];

        self::assertTrue((new Verifier(null))->verify($request, ...$secrets));
    }
}
