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
 * @method static RootAuthType ApiKey()
 * @method static RootAuthType OAuth()
 * @method static RootAuthType ClientToken()
 * @method static RootAuthType Session()
 */
final class RootAuthType extends PaddleEnum
{
    private const ApiKey = 'api_key';
    private const OAuth = 'oauth';
    private const ClientToken = 'client_token';
    private const Session = 'session';
}
