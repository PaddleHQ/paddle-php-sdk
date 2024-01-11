<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Shared\Operations\List;

final class OrderBy implements \Stringable
{
    private function __construct(private readonly string $field, private readonly string $direction)
    {
    }

    public static function idAscending(): self
    {
        return new self('id', 'asc');
    }

    public static function idDescending(): self
    {
        return new self('id', 'desc');
    }

    public function __toString(): string
    {
        return sprintf('%s[%s]', $this->field, $this->direction);
    }
}
