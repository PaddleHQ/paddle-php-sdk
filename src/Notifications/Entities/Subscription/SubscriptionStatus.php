<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Subscription;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionStatus Active()
 * @method static SubscriptionStatus Canceled()
 * @method static SubscriptionStatus PastDue()
 * @method static SubscriptionStatus Paused()
 * @method static SubscriptionStatus Trialing()
 * @method static SubscriptionStatus Inactive()
 */
final class SubscriptionStatus extends PaddleEnum
{
    private const Active = 'active';
    private const Canceled = 'canceled';
    private const PastDue = 'past_due';
    private const Paused = 'paused';
    private const Trialing = 'trialing';
    private const Inactive = 'inactive';
}
