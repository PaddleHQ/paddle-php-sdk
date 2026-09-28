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
 * @method static SubscriptionConsentRequirementStatus Pending()
 * @method static SubscriptionConsentRequirementStatus Granted()
 * @method static SubscriptionConsentRequirementStatus Voided()
 */
final class SubscriptionConsentRequirementStatus extends PaddleEnum
{
    private const Pending = 'pending';
    private const Granted = 'granted';
    private const Voided = 'voided';
}
