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

    /**
     * @test
     *
     * @dataProvider timestampVarianceProvider
     */
    public function it_rejects_timestamps_outside_maximum_variance(int $offset, bool $expected): void
    {
        $secret = 'pdl_ntfset_01hs0t3tw21j988db1pam5xg8m_GrOWLNef+vmtjJYq4mSnHNzvc8uWoJ1I';
        $body = '{"event_type":"transaction.completed"}';
        $timestamp = \time() + $offset;
        $signature = PaddleSignature::calculateHMAC("{$timestamp}:{$body}", $secret);

        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '/paddle/notifications')
            ->withHeader(PaddleSignature::HEADER, "ts={$timestamp};h1={$signature}")
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body));

        self::assertSame($expected, (new Verifier())->verify($request, new Secret($secret)));
    }

    public static function timestampVarianceProvider(): \Generator
    {
        yield 'Current timestamp' => [0, true];
        yield 'Old timestamp within variance' => [-2, true];
        yield 'Future timestamp within variance' => [2, true];
        yield 'Old timestamp' => [-60, false];
        yield 'Future timestamp' => [60, false];
        yield 'Far future timestamp' => [315360000, false];
    }

    /** @test */
    public function it_skips_timestamp_check_without_maximum_variance(): void
    {
        $secret = 'pdl_ntfset_01hs0t3tw21j988db1pam5xg8m_GrOWLNef+vmtjJYq4mSnHNzvc8uWoJ1I';
        $body = '{"event_type":"transaction.completed"}';
        $timestamp = \time() + 315360000;
        $signature = PaddleSignature::calculateHMAC("{$timestamp}:{$body}", $secret);

        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '/paddle/notifications')
            ->withHeader(PaddleSignature::HEADER, "ts={$timestamp};h1={$signature}")
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body));

        self::assertTrue((new Verifier(null))->verify($request, new Secret($secret)));
    }
}
