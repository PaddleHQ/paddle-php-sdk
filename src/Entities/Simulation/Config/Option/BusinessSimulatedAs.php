<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Simulation\Config\Option;

use Paddle\SDK\PaddleEnum;

/**
 * @method static BusinessSimulatedAs NotProvided()
 * @method static BusinessSimulatedAs New()
 * @method static BusinessSimulatedAs ExistingDetailsPrefilled()
 */
final class BusinessSimulatedAs extends PaddleEnum
{
    private const NotProvided = 'not_provided';
    private const New = 'new';
    private const ExistingDetailsPrefilled = 'existing_details_prefilled';
}
