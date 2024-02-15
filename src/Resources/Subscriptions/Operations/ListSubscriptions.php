<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Subscription\SubscriptionScheduledChangeAction;
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListSubscriptions implements HasParameters
{
    /**
     * @param array<string>                            $addressIds
     * @param array<string>                            $customerIds
     * @param array<string>                            $ids
     * @param array<string>                            $priceIds
     * @param array<SubscriptionScheduledChangeAction> $scheduledChangeActions
     * @param array<SubscriptionStatus>                $statuses
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $addressIds = [],
        private readonly CollectionMode|null $collectionMode = null,
        private readonly array $customerIds = [],
        private readonly array $ids = [],
        private readonly array $priceIds = [],
        private readonly array $scheduledChangeActions = [],
        private readonly array $statuses = [],
    ) {
        if ($invalid = array_filter($this->addressIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('addressIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->customerIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('customerIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->priceIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('priceIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->scheduledChangeActions, fn ($value): bool => ! $value instanceof SubscriptionScheduledChangeAction)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('scheduledChangeActions', SubscriptionScheduledChangeAction::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof SubscriptionStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', SubscriptionStatus::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'address_id' => implode(',', $this->addressIds),
                'collection_mode' => $this->collectionMode?->getValue(),
                'customer_id' => implode(',', $this->customerIds),
                'id' => implode(',', $this->ids),
                'price_id' => implode(',', $this->priceIds),
                'scheduled_change_action' => implode(',', array_map($enumStringify, $this->scheduledChangeActions)),
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
            ]),
        );
    }
}
