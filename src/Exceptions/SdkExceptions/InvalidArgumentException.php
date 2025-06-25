<?php

declare(strict_types=1);

namespace Paddle\SDK\Exceptions\SdkExceptions;

use Paddle\SDK\Exceptions\SdkException;

class InvalidArgumentException extends SdkException
{
    public static function arrayIsEmpty(string $field): self
    {
        return new self(sprintf('%s cannot be empty', $field));
    }

    public static function arrayContainsInvalidTypes(string $field, string $expectedType, string $given): self
    {
        return new self(sprintf(
            'expected %s to only contain only type/s %s, %s given',
            $field,
            $expectedType,
            $given,
        ));
    }

    public static function incompatibleArguments(string $incompatibleField, string $field, string|null $value = null): self
    {
        $message = sprintf('%s is not compatible with %s', $incompatibleField, $field);

        if ($value !== null) {
            $message .= ': ' . $value;
        }

        return new self($message);
    }
}
