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
 * @method static SimulationStatus Active()
 * @method static SimulationStatus Archived()
 */
final class SimulationStatus extends PaddleEnum
{
    private const Active = 'active';
    private const Archived = 'archived';
}
