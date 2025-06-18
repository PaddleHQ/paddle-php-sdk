<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Simulation;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\Simulation\SimulationEntity;
use Paddle\SDK\Tests\DataProvider\EventDataProvider;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SimulationTest extends TestCase
{
    use ReadsFixtures;

    /**
     * @test
     *
     * @dataProvider eventDataProvider
     */
    public function it_creates_simulation_from_data(string $eventType, string $entityProperty, string $eventClass, string $entityClass): void
    {
        $simulation = Simulation::from([
            'id' => 'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'notification_setting_id' => 'ntfset_01j82d983j814ypzx7m1fw2jpz',
            'name' => 'Simulation for ' . $eventType,
            'type' => $eventType,
            'created_at' => '2023-08-21T11:57:47.390028Z',
            'updated_at' => '2023-08-21T11:57:47.390028Z',
            'status' => 'active',
            'payload' => self::readJsonFixture('notification/entity/' . $eventType),
        ]);

        self::assertSame('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', $simulation->id);
        self::assertInstanceOf(Entity::class, $simulation->payload);
    }

    /**
     * @test
     *
     * @dataProvider eventDataProvider
     */
    public function it_creates_simulation_with_partial_payload(string $eventType, string $entityProperty, string $eventClass, string $entityClass): void
    {
        // Get full payload without an ID.
        $payloadData = self::readJsonFixture('notification/entity/' . $eventType);
        unset($payloadData['id']);

        $simulation = Simulation::from([
            'id' => 'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'notification_setting_id' => 'ntfset_01j82d983j814ypzx7m1fw2jpz',
            'name' => 'Simulation for ' . $eventType,
            'type' => $eventType,
            'created_at' => '2023-08-21T11:57:47.390028Z',
            'updated_at' => '2023-08-21T11:57:47.390028Z',
            'status' => 'active',
            'payload' => $payloadData,
        ]);

        self::assertSame('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', $simulation->id);

        $payload = $simulation->payload;
        self::assertInstanceOf(SimulationEntity::class, $payload);
        self::assertInstanceOf(Undefined::class, $payload->id);

        $serializer = new Serializer(
            [
                new BackedEnumNormalizer(),
                new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => DateTime::PADDLE_RFC3339]),
                new JsonSerializableNormalizer(),
                new ObjectNormalizer(nameConverter: new CamelCaseToSnakeCaseNameConverter()),
            ],
            [new JsonEncoder()],
        );

        $decodedData = $serializer->decode(
            $serializer->serialize($payload, 'json'),
            'json',
        );

        self::assertEqualsCanonicalizing(
            array_keys($payloadData),
            array_keys($decodedData),
        );
    }

    public static function eventDataProvider(): iterable
    {
        return EventDataProvider::events();
    }
}
