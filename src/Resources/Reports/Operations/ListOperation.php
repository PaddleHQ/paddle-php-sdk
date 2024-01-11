<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Reports\Operations;

use Paddle\SDK\Entities\Report\ReportStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListOperation implements HasParameters
{
    /**
     * @param array<ReportStatus> $statuses
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly ?Pager $pager = null,
        private readonly array $statuses = [],
    ) {
        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof ReportStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', ReportStatus::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->value;

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
            ]),
        );
    }
}
