<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Metrics\Operations;

use Paddle\SDK\Entities\Metrics\MetricEntity;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreMeasure;
use Paddle\SDK\Resources\Metrics\Operations\RunExploreQuery;
use PHPUnit\Framework\TestCase;

class RunExploreQueryTest extends TestCase
{
    /**
     * @test
     */
    public function it_formats_datetime_boundaries_as_rfc3339(): void
    {
        $operation = new RunExploreQuery(
            entity: MetricEntity::Checkouts(),
            from: new \DateTimeImmutable('2026-05-01T12:30:00Z'),
            to: new \DateTimeImmutable('2026-08-01T00:00:00+01:00'),
            measures: [new ExploreMeasure('count')],
        );

        $payload = $operation->jsonSerialize();

        self::assertSame('2026-05-01T12:30:00.000000Z', $payload['from']);
        self::assertSame('2026-08-01T00:00:00.000000+01:00', $payload['to']);
    }

    /**
     * @test
     *
     * @dataProvider invalidArgumentsProvider
     */
    public function it_rejects_invalid_array_items(array $arguments, string $field): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage("expected {$field} to only contain");

        new RunExploreQuery(...[
            'entity' => MetricEntity::Checkouts(),
            'from' => '2026-05-01',
            'to' => '2026-08-01',
            ...$arguments,
        ]);
    }

    public static function invalidArgumentsProvider(): \Generator
    {
        yield 'measures' => [['measures' => ['count']], 'measures'];
        yield 'filters' => [['measures' => [new ExploreMeasure('count')], 'filters' => ['country']], 'filters'];
        yield 'order by' => [['measures' => [new ExploreMeasure('count')], 'orderBy' => ['count']], 'orderBy'];
    }
}
