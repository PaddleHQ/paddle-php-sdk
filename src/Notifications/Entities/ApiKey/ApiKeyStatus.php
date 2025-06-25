<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\ApiKey;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ApiKeyStatus Active()
 * @method static ApiKeyStatus Expired()
 * @method static ApiKeyStatus Revoked()
 */
final class ApiKeyStatus extends PaddleEnum
{
    private const Active = 'active';
    private const Expired = 'expired';
    private const Revoked = 'revoked';
}
