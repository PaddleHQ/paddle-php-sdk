<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionDiscountType Recurring()
 * @method static SubscriptionDiscountType OneOff()
 */
final class SubscriptionDiscountType extends PaddleEnum
{
    private const Recurring = 'recurring';
    private const OneOff = 'one-off';
}
