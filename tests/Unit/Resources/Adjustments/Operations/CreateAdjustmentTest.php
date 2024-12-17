<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Adjustments\Operations;

use Paddle\SDK\Entities\Adjustment\AdjustmentType;
use Paddle\SDK\Entities\Shared\Action;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Adjustments\Operations\CreateAdjustment;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;

class CreateAdjustmentTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider invalidItemsDataProvider
     */
    public function it_validates_items(array|Undefined|null $items, AdjustmentType $type, string $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        new CreateAdjustment(
            Action::Refund(),
            $items,
            'error',
            'txn_01h8bxpvx398a7zbawb77y0kp5',
            $type,
        );
    }

    public static function invalidItemsDataProvider(): \Generator
    {
        yield 'Empty' => [
            [],
            AdjustmentType::Partial(),
            'items cannot be empty',
        ];
        yield 'Undefined' => [
            new Undefined(),
            AdjustmentType::Partial(),
            'items cannot be empty',
        ];
        yield 'Null' => [
            null,
            AdjustmentType::Partial(),
            'items cannot be empty',
        ];
        yield 'Items for full type' => [
            [],
            AdjustmentType::Full(),
            'items are not allowed when the adjustment type is full',
        ];
    }
}
