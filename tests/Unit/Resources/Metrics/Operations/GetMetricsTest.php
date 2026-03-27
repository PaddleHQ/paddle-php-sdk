<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Metrics\Operations;

use Paddle\SDK\Resources\Metrics\Operations\GetMetrics;
use PHPUnit\Framework\TestCase;

class GetMetricsTest extends TestCase
{
    /**
     * @test
     */
    public function it_accepts_valid_date_strings(): void
    {
        $operation = new GetMetrics(from: '2025-09-01', to: '2025-09-05');

        self::assertSame(['from' => '2025-09-01', 'to' => '2025-09-05'], $operation->getParameters());
    }

    /**
     * @test
     *
     * @dataProvider invalidDatetimeProvider
     */
    public function it_rejects_datetime_strings(string $from, string $to): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('YYYY-MM-DD format');

        new GetMetrics(from: $from, to: $to);
    }

    public static function invalidDatetimeProvider(): \Generator
    {
        yield 'from with datetime' => ['2025-09-01T00:00:00Z', '2025-09-05'];
        yield 'to with datetime' => ['2025-09-01', '2025-09-05T23:59:59Z'];
        yield 'from with microseconds' => ['2025-09-01T00:00:00.000000Z', '2025-09-05'];
    }

    /**
     * @test
     *
     * @dataProvider invalidDateStringProvider
     */
    public function it_rejects_invalid_date_strings(string $from, string $to): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('YYYY-MM-DD format');

        new GetMetrics(from: $from, to: $to);
    }

    public static function invalidDateStringProvider(): \Generator
    {
        yield 'from not a date' => ['not-a-date', '2025-09-05'];
        yield 'to not a date' => ['2025-09-01', 'invalid'];
        yield 'from empty string' => ['', '2025-09-05'];
        yield 'from wrong separator' => ['2025/09/01', '2025-09-05'];
        yield 'from wrong order' => ['01-09-2025', '2025-09-05'];
    }
}
