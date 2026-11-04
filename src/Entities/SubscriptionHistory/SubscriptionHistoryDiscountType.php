<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionHistoryDiscountType Recurring()
 * @method static SubscriptionHistoryDiscountType OneOff()
 */
final class SubscriptionHistoryDiscountType extends PaddleEnum
{
    private const Recurring = 'recurring';
    private const OneOff = 'one-off';
}
