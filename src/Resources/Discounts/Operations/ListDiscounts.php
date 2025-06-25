<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Discounts\Operations;

use Paddle\SDK\Entities\Discount\DiscountMode;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListDiscounts implements HasParameters
{
    /**
     * @param array<string>          $ids
     * @param array<Status>          $statuses
     * @param array<string>          $codes
     * @param array<string>          $discountGroupIds
     * @param array<DiscountInclude> $includes
     *
     * @throws InvalidArgumentException On invalid array contents
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $ids = [],
        private readonly array $statuses = [],
        private readonly array $codes = [],
        private readonly array $discountGroupIds = [],
        private readonly DiscountMode|null $mode = null,
        private readonly array $includes = [],
    ) {
        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof Status)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', Status::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->codes, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('codes', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->discountGroupIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('discountGroupIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->includes, fn ($value): bool => ! $value instanceof DiscountInclude)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('includes', DiscountInclude::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'id' => implode(',', $this->ids),
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
                'code' => implode(',', $this->codes),
                'discount_group_id' => implode(',', $this->discountGroupIds),
                'mode' => $this->mode?->getValue(),
                'include' => implode(',', $this->includes),
            ]),
        );
    }
}
