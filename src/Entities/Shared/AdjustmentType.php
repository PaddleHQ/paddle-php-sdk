<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum AdjustmentType: string
{
    case Full = 'full';
    case Partial = 'partial';
    case Tax = 'tax';
    case Proration = 'proration';
}
