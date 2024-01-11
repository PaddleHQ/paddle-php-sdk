<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum TaxMode: string
{
    case AccountSetting = 'account_setting';
    case External = 'external';
    case Internal = 'internal';
}
