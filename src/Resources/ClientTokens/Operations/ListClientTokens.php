<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\ClientTokens\Operations;

use Paddle\SDK\Entities\ClientToken\ClientTokenStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListClientTokens implements HasParameters
{
    /**
     * @param array<ClientTokenStatus> $statuses
     *
     * @throws InvalidArgumentException On invalid array contents
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $statuses = [],
    ) {
        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof ClientTokenStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', ClientTokenStatus::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
            ]),
        );
    }
}
