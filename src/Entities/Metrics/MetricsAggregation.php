<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

use Paddle\SDK\PaddleEnum;

/**
 * @method static MetricsAggregation Count()
 * @method static MetricsAggregation CountDistinct()
 * @method static MetricsAggregation Sum()
 */
final class MetricsAggregation extends PaddleEnum
{
    private const Count = 'count';
    private const CountDistinct = 'count_distinct';
    private const Sum = 'sum';
}
