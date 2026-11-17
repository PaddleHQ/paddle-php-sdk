<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Shared\CollectionMode;

class SubscriptionHistoryDetailSubscriptionCollectionModeUpdated implements SubscriptionHistoryDetail
{
    private function __construct(
        public SubscriptionHistoryAction $action,
        public CollectionMode $collectionMode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            action: SubscriptionHistoryAction::from($data['action']),
            collectionMode: CollectionMode::from($data['collection_mode']),
        );
    }
}
