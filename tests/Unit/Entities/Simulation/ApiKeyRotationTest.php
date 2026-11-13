<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Simulation;

use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Notifications\Entities\ApiKeyRotation\ApiKeyRotationStatus;
use Paddle\SDK\Notifications\Entities\Simulation\ApiKeyRotation;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;

class ApiKeyRotationTest extends TestCase
{
    use ReadsFixtures;

    /**
     * @test
     */
    public function it_round_trips_a_full_payload(): void
    {
        $rotation = ApiKeyRotation::from(self::readJsonFixture('notification/entity/api_key_rotation.updated'));

        self::assertEquals(ApiKeyRotationStatus::Completed(), $rotation->status);
        self::assertSame(3600, $rotation->gracePeriodSeconds);
        self::assertSame('2026-11-02T00:00:00.000000Z', $rotation->newKeyExpiresAt->format('Y-m-d\TH:i:s.u\Z'));

        $payload = json_decode(JsonEncoder::default()->encode($rotation), true);
        self::assertSame('apikey_01jkdpbhazdpn3wpcya45as9tg', $payload['api_key_id']);
        self::assertSame('completed', $payload['status']);
    }

    /**
     * @test
     */
    public function it_omits_undefined_and_keeps_null(): void
    {
        $rotation = ApiKeyRotation::from(['id' => 'apkrot_01jkas9tppn3bhadwpcyag45zd', 'expires_at' => null]);

        self::assertInstanceOf(Undefined::class, $rotation->newKeyExpiresAt);
        self::assertNull($rotation->expiresAt);
        self::assertSame(
            ['id' => 'apkrot_01jkas9tppn3bhadwpcyag45zd', 'expires_at' => null],
            json_decode(JsonEncoder::default()->encode($rotation), true),
        );
    }
}
