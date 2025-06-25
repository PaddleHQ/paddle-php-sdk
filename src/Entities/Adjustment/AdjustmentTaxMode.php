<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Adjustment;

use Paddle\SDK\PaddleEnum;

/**
 * @method static AdjustmentTaxMode External()
 * @method static AdjustmentTaxMode Internal()
 */
final class AdjustmentTaxMode extends PaddleEnum
{
    private const External = 'external';
    private const Internal = 'internal';
}
