<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\ApiKeyExposure;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ApiKeyExposureSource Github()
 */
final class ApiKeyExposureSource extends PaddleEnum
{
    private const Github = 'github';
}
