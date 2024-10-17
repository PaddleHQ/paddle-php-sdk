<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SimulationRunEvent;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SimulationRunEventStatus Aborted()
 * @method static SimulationRunEventStatus Failed()
 * @method static SimulationRunEventStatus Success()
 * @method static SimulationRunEventStatus Pending()
 */
final class SimulationRunEventStatus extends PaddleEnum
{
    private const Aborted = 'aborted';
    private const Failed = 'failed';
    private const Success = 'success';
    private const Pending = 'pending';
}
