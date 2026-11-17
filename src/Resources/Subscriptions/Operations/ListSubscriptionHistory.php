<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\Shared\ActionSource;
use Paddle\SDK\Entities\Shared\ActorType;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryAction;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryReason;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\DateComparison;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListSubscriptionHistory implements HasParameters
{
    /**
     * @param array<SubscriptionHistoryAction> $actions
     * @param array<ActionSource>              $sources
     * @param array<ActorType>                 $actorTypes
     * @param array<string>                    $actorIds
     * @param array<SubscriptionHistoryReason> $reasons
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $actions = [],
        private readonly array $sources = [],
        private readonly array $actorTypes = [],
        private readonly array $actorIds = [],
        private readonly array $reasons = [],
        private readonly DateComparison|null $occurredAt = null,
    ) {
        if ($invalid = array_filter($this->actions, fn ($value): bool => ! $value instanceof SubscriptionHistoryAction)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('actions', SubscriptionHistoryAction::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->sources, fn ($value): bool => ! $value instanceof ActionSource)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('sources', ActionSource::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->actorTypes, fn ($value): bool => ! $value instanceof ActorType)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('actorTypes', ActorType::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->actorIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('actorIds', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->reasons, fn ($value): bool => ! $value instanceof SubscriptionHistoryReason)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('reasons', SubscriptionHistoryReason::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'action' => implode(',', array_map($enumStringify, $this->actions)),
                'source' => implode(',', array_map($enumStringify, $this->sources)),
                'actor_type' => implode(',', array_map($enumStringify, $this->actorTypes)),
                'actor_id' => implode(',', $this->actorIds),
                'reason' => implode(',', array_map($enumStringify, $this->reasons)),
                'occurred_at' . $this->occurredAt?->comparator() => $this->occurredAt?->formatted(),
            ]),
        );
    }
}
