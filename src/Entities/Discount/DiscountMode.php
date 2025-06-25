<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Discount;

use Paddle\SDK\PaddleEnum;

/**
 * @method static DiscountMode Standard()
 * @method static DiscountMode Custom()
 */
final class DiscountMode extends PaddleEnum
{
    private const Standard = 'standard';
    private const Custom = 'custom';
}
