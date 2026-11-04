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
 * @method static ActorType Customer()
 * @method static ActorType User()
 * @method static ActorType ApiKey()
 * @method static ActorType PaddleStaff()
 * @method static ActorType Publisher()
 * @method static ActorType System()
 */
final class ActorType extends PaddleEnum
{
    private const Customer = 'customer';
    private const User = 'user';
    private const ApiKey = 'api_key';
    private const PaddleStaff = 'paddle_staff';
    private const Publisher = 'publisher';
    private const System = 'system';
}
