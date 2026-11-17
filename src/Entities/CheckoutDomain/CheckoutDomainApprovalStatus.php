<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\CheckoutDomain;

use Paddle\SDK\PaddleEnum;

/**
 * @method static CheckoutDomainApprovalStatus PendingReview()
 * @method static CheckoutDomainApprovalStatus Approved()
 * @method static CheckoutDomainApprovalStatus Rejected()
 * @method static CheckoutDomainApprovalStatus InReview()
 * @method static CheckoutDomainApprovalStatus ActionRequired()
 */
final class CheckoutDomainApprovalStatus extends PaddleEnum
{
    private const PendingReview = 'pending_review';
    private const Approved = 'approved';
    private const Rejected = 'rejected';
    private const InReview = 'in_review';
    private const ActionRequired = 'action_required';
}
