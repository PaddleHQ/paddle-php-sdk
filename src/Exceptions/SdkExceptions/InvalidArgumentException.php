<?php

declare(strict_types=1);

namespace Paddle\SDK\Exceptions\SdkExceptions;

use Paddle\SDK\Exceptions\SdkException;

class InvalidArgumentException extends SdkException
{
    public static function arrayContainsInvalidTypes(string $field, string $expectedType, string $given): self
    {
        return new self(sprintf(
            'expected %s to only contain only type/s %s, %s given',
            $field,
            $expectedType,
            $given,
        ));
    }
}
