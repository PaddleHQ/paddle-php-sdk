<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Adjustments\Operations;

use Paddle\SDK\Entities\Shared\Action;
use Paddle\SDK\Entities\Shared\AdjustmentStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListAdjustments implements HasParameters
{
    /**
     * @param array<string>           $ids
     * @param array<AdjustmentStatus> $statuses
     * @param array<string>           $customerIds
     * @param array<string>           $transactionIds
     * @param array<string>           $subscriptionIds
     *
     * @throws InvalidArgumentException On invalid array arguments
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $ids = [],
        private readonly array $statuses = [],
        private readonly array $customerIds = [],
        private readonly array $transactionIds = [],
        private readonly array $subscriptionIds = [],
        private readonly Action|null $action = null,
    ) {
        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof AdjustmentStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', AdjustmentStatus::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->customerIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('customerIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->transactionIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('transactionIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->subscriptionIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('subscriptionIds', 'string', implode(', ', $invalid));
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
                'customer_id' => implode(',', $this->customerIds),
                'transaction_id' => implode(',', $this->transactionIds),
                'subscription_id' => implode(',', $this->subscriptionIds),
                'action' => $this->action?->getValue(),
            ]),
        );
    }
}
