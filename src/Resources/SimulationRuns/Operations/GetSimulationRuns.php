<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\SimulationRuns\Operations;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;

class GetSimulationRuns implements HasParameters
{
    public function __construct(
        private readonly array $includes = [],
    ) {
        if ($invalid = array_filter($this->includes, fn ($value): bool => ! $value instanceof Includes)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('includes', Includes::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_filter([
            'include' => implode(',', array_map($enumStringify, $this->includes)),
        ]);
    }
}
