<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\PaddleEnum;

/**
 * @method static DefaultTaxMode Exclusive()
 * @method static DefaultTaxMode Inclusive()
 * @method static DefaultTaxMode Location()
 */
final class DefaultTaxMode extends PaddleEnum
{
    private const Exclusive = 'exclusive';
    private const Inclusive = 'inclusive';
    private const Location = 'location';
}
