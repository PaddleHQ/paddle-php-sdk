<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Metrics;

use Paddle\SDK\Entities\Metrics\MetricsExplorePagination;
use Paddle\SDK\Entities\Shared\Pagination;
use PHPUnit\Framework\TestCase;

class MetricsExplorePaginationTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider afterProvider
     */
    public function it_parses_the_after_cursor_from_next(string $next, bool $hasMore, string|null $expected): void
    {
        $pagination = MetricsExplorePagination::from(new Pagination(5, $next, $hasMore, 42));

        self::assertSame(5, $pagination->perPage);
        self::assertSame($next, $pagination->next);
        self::assertSame($hasMore, $pagination->hasMore);
        self::assertSame(42, $pagination->estimatedTotal);
        self::assertSame($expected, $pagination->after);
    }

    public static function afterProvider(): \Generator
    {
        yield 'Next page' => ['https://api.paddle.com/metrics/explore?after=eyJjIjoxfQ', true, 'eyJjIjoxfQ'];
        yield 'Cursor among other query parameters' => ['https://api.paddle.com/metrics/explore?per_page=5&after=eyJjIjoxfQ', true, 'eyJjIjoxfQ'];
        yield 'Last page' => ['', false, null];
        yield 'Last page with a next URL' => ['https://api.paddle.com/metrics/explore?after=eyJjIjoxfQ', false, null];
        yield 'Empty next with more pages' => ['', true, null];
        yield 'Next without a cursor' => ['https://api.paddle.com/metrics/explore', true, null];
        yield 'Empty cursor' => ['https://api.paddle.com/metrics/explore?after=', true, null];
    }
}
