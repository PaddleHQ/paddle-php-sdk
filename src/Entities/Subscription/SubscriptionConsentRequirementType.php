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
 * @method static SubscriptionConsentRequirementType TrialEnding()
 * @method static SubscriptionConsentRequirementType IntroductoryDiscountEnding()
 */
final class SubscriptionConsentRequirementType extends PaddleEnum
{
    private const TrialEnding = 'trial_ending';
    private const IntroductoryDiscountEnding = 'introductory_discount_ending';
}
