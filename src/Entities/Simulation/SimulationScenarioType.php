<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Simulation;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SimulationScenarioType SubscriptionCreation()
 * @method static SimulationScenarioType SubscriptionRenewal()
 * @method static SimulationScenarioType SubscriptionPause()
 * @method static SimulationScenarioType SubscriptionResume()
 * @method static SimulationScenarioType SubscriptionCancellation()
 */
final class SimulationScenarioType extends PaddleEnum
{
    private const SubscriptionCreation = 'subscription_creation';
    private const SubscriptionRenewal = 'subscription_renewal';
    private const SubscriptionPause = 'subscription_pause';
    private const SubscriptionResume = 'subscription_resume';
    private const SubscriptionCancellation = 'subscription_cancellation';
}
