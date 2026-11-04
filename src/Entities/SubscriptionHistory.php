<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\ActionSource;
use Paddle\SDK\Entities\Shared\Actor;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetail;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailFactory;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryReason;

class SubscriptionHistory implements Entity
{
    private function __construct(
        public string $id,
        public string $groupId,
        public string $subscriptionId,
        public \DateTimeInterface $occurredAt,
        public ActionSource $source,
        public Actor $actor,
        public SubscriptionHistoryReason|null $reason,
        public SubscriptionHistoryDetail $detail,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            groupId: $data['group_id'],
            subscriptionId: $data['subscription_id'],
            occurredAt: DateTime::from($data['occurred_at']),
            source: ActionSource::from($data['source']),
            actor: Actor::from($data['actor']),
            reason: isset($data['reason']) ? SubscriptionHistoryReason::from($data['reason']) : null,
            detail: SubscriptionHistoryDetailFactory::from($data['detail']),
        );
    }
}
