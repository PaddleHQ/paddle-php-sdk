<?php

declare(strict_types=1);

namespace Paddle\SDK;

interface HasParameters
{
    /**
     * Implementations of this method should return an associative array of parameters
     * suitable to be used in API calls, e.g. foo => bar which would result in foo=bar in an API call.
     *
     * @return array<string, mixed>
     */
    public function getParameters(): array;
}
