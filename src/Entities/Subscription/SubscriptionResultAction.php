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
 * @method static SubscriptionResultAction Credit()
 * @method static SubscriptionResultAction Charge()
 */
final class SubscriptionResultAction extends PaddleEnum
{
    private const Credit = 'credit';
    private const Charge = 'charge';
}
