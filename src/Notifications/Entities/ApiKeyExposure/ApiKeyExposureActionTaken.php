<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\ApiKeyExposure;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ApiKeyExposureActionTaken Revoked()
 * @method static ApiKeyExposureActionTaken None()
 */
final class ApiKeyExposureActionTaken extends PaddleEnum
{
    private const Revoked = 'revoked';
    private const None = 'none';
}
