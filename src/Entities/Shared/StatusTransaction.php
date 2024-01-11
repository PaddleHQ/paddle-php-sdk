<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum StatusTransaction: string
{
    case Draft = 'draft';
    case Ready = 'ready';
    case Billed = 'billed';
    case Paid = 'paid';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case PastDue = 'past_due';
}
