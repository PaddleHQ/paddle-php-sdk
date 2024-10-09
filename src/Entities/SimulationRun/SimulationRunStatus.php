<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SimulationRun;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SimulationRunStatus Canceled()
 * @method static SimulationRunStatus Completed()
 * @method static SimulationRunStatus Pending()
 */
final class SimulationRunStatus extends PaddleEnum
{
    private const Canceled = 'canceled';
    private const Completed = 'completed';
    private const Pending = 'pending';
}
