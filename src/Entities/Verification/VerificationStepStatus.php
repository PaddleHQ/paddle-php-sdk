<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Verification;

use Paddle\SDK\PaddleEnum;

/**
 * @method static VerificationStepStatus Pending()
 * @method static VerificationStepStatus InProgress()
 * @method static VerificationStepStatus InReview()
 * @method static VerificationStepStatus ActionRequired()
 * @method static VerificationStepStatus Failed()
 * @method static VerificationStepStatus Completed()
 */
final class VerificationStepStatus extends PaddleEnum
{
    private const Pending = 'pending';
    private const InProgress = 'in_progress';
    private const InReview = 'in_review';
    private const ActionRequired = 'action_required';
    private const Failed = 'failed';
    private const Completed = 'completed';
}
