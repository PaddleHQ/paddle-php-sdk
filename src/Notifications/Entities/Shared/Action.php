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
 * @method static Action Credit()
 * @method static Action CreditReverse()
 * @method static Action Refund()
 * @method static Action Chargeback()
 * @method static Action ChargebackReverse()
 * @method static Action ChargebackWarning()
 */
final class Action extends PaddleEnum
{
    private const Credit = 'credit';
    private const CreditReverse = 'credit_reverse';
    private const Refund = 'refund';
    private const Chargeback = 'chargeback';
    private const ChargebackReverse = 'chargeback_reverse';
    private const ChargebackWarning = 'chargeback_warning';
}
