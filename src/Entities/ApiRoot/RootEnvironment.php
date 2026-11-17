<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\ApiRoot;

use Paddle\SDK\PaddleEnum;

/**
 * @method static RootEnvironment Production()
 * @method static RootEnvironment Sandbox()
 */
final class RootEnvironment extends PaddleEnum
{
    private const Production = 'production';
    private const Sandbox = 'sandbox';
}
