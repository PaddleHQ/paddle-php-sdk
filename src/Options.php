<?php

declare(strict_types=1);

namespace Paddle\SDK;

class Options
{
    public function __construct(
        public Environment $environment = Environment::PRODUCTION,
        public int $retries = 1,
    ) {
    }
}
