<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

enum SubscriptionScheduledChangeAction: string
{
    case Cancel = 'cancel';
    case Pause = 'pause';
    case Resume = 'resume';
}
