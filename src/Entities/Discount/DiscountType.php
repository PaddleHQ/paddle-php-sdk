<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Discount;

enum DiscountType: string
{
    case Flat = 'flat';
    case FlatPerSeat = 'flat_per_seat';
    case Percentage = 'percentage';
}
