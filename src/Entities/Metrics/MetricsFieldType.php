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
 * @method static MetricsFieldType String()
 * @method static MetricsFieldType Integer()
 * @method static MetricsFieldType Decimal()
 * @method static MetricsFieldType Currency()
 */
final class MetricsFieldType extends PaddleEnum
{
    private const String = 'string';
    private const Integer = 'integer';
    private const Decimal = 'decimal';
    private const Currency = 'currency';
}
