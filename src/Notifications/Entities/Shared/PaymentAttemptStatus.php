<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static PaymentAttemptStatus Authorized()
 * @method static PaymentAttemptStatus AuthorizedFlagged()
 * @method static PaymentAttemptStatus Canceled()
 * @method static PaymentAttemptStatus Captured()
 * @method static PaymentAttemptStatus Error()
 * @method static PaymentAttemptStatus ActionRequired()
 * @method static PaymentAttemptStatus PendingNoActionRequired()
 * @method static PaymentAttemptStatus Created()
 * @method static PaymentAttemptStatus Unknown()
 * @method static PaymentAttemptStatus Dropped()
 */
final class PaymentAttemptStatus extends PaddleEnum
{
    private const Authorized = 'authorized';
    private const AuthorizedFlagged = 'authorized_flagged';
    private const Canceled = 'canceled';
    private const Captured = 'captured';
    private const Error = 'error';
    private const ActionRequired = 'action_required';
    private const PendingNoActionRequired = 'pending_no_action_required';
    private const Created = 'created';
    private const Unknown = 'unknown';
    private const Dropped = 'dropped';
}
