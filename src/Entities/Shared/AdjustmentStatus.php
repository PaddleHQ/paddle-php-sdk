<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static AdjustmentStatus PendingApproval()
 * @method static AdjustmentStatus Approved()
 * @method static AdjustmentStatus Rejected()
 * @method static AdjustmentStatus Reversed()
 */
final class AdjustmentStatus extends PaddleEnum
{
    private const PendingApproval = 'pending_approval';
    private const Approved = 'approved';
    private const Rejected = 'rejected';
    private const Reversed = 'reversed';
}
