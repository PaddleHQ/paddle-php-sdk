<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Discount;

use Paddle\SDK\PaddleEnum;

/**
 * @method static DiscountStatus Active()
 * @method static DiscountStatus Archived()
 * @method static DiscountStatus Expired()
 * @method static DiscountStatus Used()
 */
final class DiscountStatus extends PaddleEnum
{
    private const Active = 'active';
    private const Archived = 'archived';
    private const Expired = 'expired';
    private const Used = 'used';
}
