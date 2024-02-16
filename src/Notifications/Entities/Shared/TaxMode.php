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
 * @method static TaxMode AccountSetting()
 * @method static TaxMode External()
 * @method static TaxMode Internal()
 */
final class TaxMode extends PaddleEnum
{
    private const AccountSetting = 'account_setting';
    private const External = 'external';
    private const Internal = 'internal';
}
