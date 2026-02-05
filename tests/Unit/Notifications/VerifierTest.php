<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Notifications;

use Http\Discovery\Psr17FactoryDiscovery;
use Paddle\SDK\Notifications\PaddleSignature;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;

class VerifierTest extends TestCase
{
    use ReadsFixtures;

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
     * @dataProvider verifyPayloadProvider
     */
    public function it_verifies_payloads(string $signature, string $secret, string $payload): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '/paddle/notifications')
            ->withHeader(
                PaddleSignature::HEADER,
                $signature,
            )
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream($payload),
            );

        self::assertTrue((new Verifier(null))->verify($request, new Secret($secret)));
    }

    public static function verifyPayloadProvider(): \Generator
    {
        $secret = 'pdl_ntfset_01hs0t3tw21j988db1pam5xg8m_GrOWLNef+vmtjJYq4mSnHNzvc8uWoJ1I';

        yield 'Standard Payload' => [
            'ts=1710498758;h1=558bf93944dbeb4790c7a8af6cb2ea435c8ca9c8396aafc1a4e37424ac132744',
            $secret,
            self::readRawJsonFixture('standard_payload'),
        ];

        yield 'Special Characters' => [
            'ts=1710498288;h1=38219b3ba1578184e625c29d201a27cd25bd69e2ec9c3ab87dcb90d87ff73a41',
            $secret,
            self::readRawJsonFixture('special_chars_payload'),
        ];
    }
}
