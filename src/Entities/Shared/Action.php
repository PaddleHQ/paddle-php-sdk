<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum Action: string
{
    case Credit = 'credit';
    case CreditReverse = 'credit_reverse';
    case Refund = 'refund';
    case Chargeback = 'chargeback';
    case ChargebackReverse = 'chargeback_reverse';
    case ChargebackWarning = 'chargeback_warning';
}
