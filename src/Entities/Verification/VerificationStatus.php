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
 * @method static VerificationStatus Pending()
 * @method static VerificationStatus InProgress()
 * @method static VerificationStatus InReview()
 * @method static VerificationStatus ActionRequired()
 * @method static VerificationStatus Completed()
 * @method static VerificationStatus Failed()
 */
final class VerificationStatus extends PaddleEnum
{
    private const Pending = 'pending';
    private const InProgress = 'in_progress';
    private const InReview = 'in_review';
    private const ActionRequired = 'action_required';
    private const Completed = 'completed';
    private const Failed = 'failed';
}
