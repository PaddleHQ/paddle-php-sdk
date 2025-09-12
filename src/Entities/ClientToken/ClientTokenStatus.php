<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\ClientToken;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ClientTokenStatus Active()
 * @method static ClientTokenStatus Revoked()
 */
final class ClientTokenStatus extends PaddleEnum
{
    private const Active = 'active';
    private const Revoked = 'revoked';
}
