<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static Status Active()
 * @method static Status Archived()
 */
final class Status extends PaddleEnum
{
    private const Active = 'active';
    private const Archived = 'archived';
}
