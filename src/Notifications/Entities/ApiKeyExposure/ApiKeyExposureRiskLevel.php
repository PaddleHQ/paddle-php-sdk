<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\ApiKeyExposure;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ApiKeyExposureRiskLevel High()
 * @method static ApiKeyExposureRiskLevel Low()
 */
final class ApiKeyExposureRiskLevel extends PaddleEnum
{
    private const High = 'high';
    private const Low = 'low';
}
