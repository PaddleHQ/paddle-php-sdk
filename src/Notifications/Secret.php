<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications;

final class Secret
{
    public function __construct(
        #[\SensitiveParameter]
        public readonly string $key,
    ) {
    }
}
