<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum StatusPaymentAttempt: string
{
    case Authorized = 'authorized';
    case AuthorizedFlagged = 'authorized_flagged';
    case Canceled = 'canceled';
    case Captured = 'captured';
    case Error = 'error';
    case ActionRequired = 'action_required';
    case PendingNoActionRequired = 'pending_no_action_required';
    case Created = 'created';
    case Unknown = 'unknown';
    case Dropped = 'dropped';
}
