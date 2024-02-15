<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations;

use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\TransactionStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\DateComparison;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Transactions\Operations\List\Includes;
use Paddle\SDK\Resources\Transactions\Operations\List\Origin;

class ListTransactions implements HasParameters
{
    /**
     * @param array<string>            $customerIds
     * @param array<string>            $ids
     * @param array<Includes>          $includes
     * @param array<string>            $invoiceNumbers
     * @param array<TransactionStatus> $statuses
     * @param array<string>            $subscriptionIds
     * @param array<Origin>            $origins
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly DateComparison|null $billedAt = null,
        private readonly CollectionMode|null $collectionMode = null,
        private readonly DateComparison|null $createdAt = null,
        private readonly array $customerIds = [],
        private readonly array $ids = [],
        private readonly array $includes = [],
        private readonly array $invoiceNumbers = [],
        private readonly array $statuses = [],
        private readonly array $subscriptionIds = [],
        private readonly DateComparison|null $updatedAt = null,
        private readonly array $origins = [],
    ) {
        if ($invalid = array_filter($this->customerIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('customerIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->includes, fn ($value): bool => ! $value instanceof Includes)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('includes', Includes::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->invoiceNumbers, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('invoiceNumbers', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof TransactionStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', TransactionStatus::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->subscriptionIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('subscriptionIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->origins, fn ($value): bool => ! $value instanceof Origin)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('origins', Origin::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'billed_at' . $this->billedAt?->comparator() => $this->billedAt?->formatted(),
                'collection_mode' => $this->collectionMode?->getValue(),
                'created_at' . $this->createdAt?->comparator() => $this->createdAt?->formatted(),
                'customer_id' => implode(',', $this->customerIds),
                'id' => implode(',', $this->ids),
                'include' => implode(',', array_map($enumStringify, $this->includes)),
                'invoice_number' => implode(',', $this->invoiceNumbers),
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
                'subscription_id' => implode(',', $this->subscriptionIds),
                'updated_at' . $this->updatedAt?->comparator() => $this->updatedAt?->formatted(),
                'origin' => implode(',', array_map($enumStringify, $this->origins)),
            ]),
        );
    }
}
