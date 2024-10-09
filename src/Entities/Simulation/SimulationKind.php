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
 * @method static SimulationKind Scenario()
 * @method static SimulationKind SingleEvent()
 */
final class SimulationKind extends PaddleEnum
{
    private const Scenario = 'scenario';
    private const SingleEvent = 'single_event';
}
