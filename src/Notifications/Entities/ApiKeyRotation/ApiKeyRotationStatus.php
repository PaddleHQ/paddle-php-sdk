<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\ApiKeyRotation;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ApiKeyRotationStatus Pending()
 * @method static ApiKeyRotationStatus Completed()
 * @method static ApiKeyRotationStatus Canceled()
 * @method static ApiKeyRotationStatus Expired()
 */
final class ApiKeyRotationStatus extends PaddleEnum
{
    private const Pending = 'pending';
    private const Completed = 'completed';
    private const Canceled = 'canceled';
    private const Expired = 'expired';
}
