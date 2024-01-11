<?php

declare(strict_types=1);

namespace Paddle\SDK;

enum Environment: string
{
    case PRODUCTION = 'production';
    case SANDBOX = 'sandbox';

    public function baseUrl(): string
    {
        return match ($this) {
            self::PRODUCTION => 'https://api.paddle.com',
            self::SANDBOX => 'https://sandbox-api.paddle.com',
        };
    }
}
