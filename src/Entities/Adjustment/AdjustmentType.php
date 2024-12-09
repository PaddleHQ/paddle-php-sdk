<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Adjustment;

use Paddle\SDK\PaddleEnum;

/**
 * @method static AdjustmentType Full()
 * @method static AdjustmentType Partial()
 */
final class AdjustmentType extends PaddleEnum
{
    private const Full = 'full';
    private const Partial = 'partial';
}
