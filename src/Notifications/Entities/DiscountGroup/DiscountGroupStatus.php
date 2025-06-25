<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\DiscountGroup;

use Paddle\SDK\PaddleEnum;

/**
 * @method static DiscountGroupStatus Active()
 * @method static DiscountGroupStatus Archived()
 */
final class DiscountGroupStatus extends PaddleEnum
{
    private const Active = 'active';
    private const Archived = 'archived';
}
