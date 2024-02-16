<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Payout;

use Paddle\SDK\PaddleEnum;

/**
 * @method static PayoutStatus Unpaid()
 * @method static PayoutStatus Paid()
 */
final class PayoutStatus extends PaddleEnum
{
    private const Unpaid = 'unpaid';
    private const Paid = 'paid';
}
