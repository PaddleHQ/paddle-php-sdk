<?php

declare(strict_types=1);

namespace Paddle\SDK\Exceptions;

class FieldError
{
    public function __construct(public string $field, public string $error)
    {
    }
}
