<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Simulation;

use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Notifications\Entities\Simulation\ApiKey;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;

class ApiKeyTest extends TestCase
{
    use ReadsFixtures;

    /**
     * @test
     */
    public function it_supports_exposed_at(): void
    {
        $apiKey = ApiKey::from(self::readJsonFixture('notification/entity/api_key.revoked'));

        self::assertInstanceOf(\DateTimeInterface::class, $apiKey->exposedAt);
        self::assertSame('2025-03-27T09:12:44.104331Z', $apiKey->exposedAt->format('Y-m-d\TH:i:s.u\Z'));

        $payload = json_decode(JsonEncoder::default()->encode($apiKey), true);
        self::assertSame('2025-03-27T09:12:44.104331Z', $payload['exposed_at']);
    }

    /**
     * @test
     */
    public function it_supports_null_exposed_at(): void
    {
        $apiKey = ApiKey::from(self::readJsonFixture('notification/entity/api_key.created'));

        self::assertNull($apiKey->exposedAt);

        $payload = json_decode(JsonEncoder::default()->encode($apiKey), true);
        self::assertArrayHasKey('exposed_at', $payload);
        self::assertNull($payload['exposed_at']);
    }

    /**
     * @test
     */
    public function it_omits_exposed_at_when_undefined(): void
    {
        $apiKey = ApiKey::from(['id' => 'apikey_01jkdpbhazdpn3wpcya45as9tg']);

        self::assertInstanceOf(Undefined::class, $apiKey->exposedAt);
        self::assertSame(
            ['id' => 'apikey_01jkdpbhazdpn3wpcya45as9tg'],
            json_decode(JsonEncoder::default()->encode($apiKey), true),
        );
    }
}
