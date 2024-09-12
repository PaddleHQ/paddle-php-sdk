<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\PricingPreviews\Operations;

use Paddle\SDK\Entities\PricingPreview\PricePreviewItem;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\PricingPreviews\Operations\PreviewPrice;
use PHPUnit\Framework\TestCase;

class PreviewPriceTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider invalidItemsDataProvider
     */
    public function it_validates_items(array $items, string $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        new PreviewPrice($items);
    }

    public static function invalidItemsDataProvider(): \Generator
    {
        yield 'Empty' => [
            [],
            'items cannot be empty',
        ];

        yield 'Invalid Types' => [
            ['some string', new PricePreviewItem('pri_01gsz8z1q1n00f12qt82y31smh', 20), 123],
            sprintf(
                'expected items to only contain only type/s %s, some string, 123 given',
                PricePreviewItem::class,
            ),
        ];
    }
}
