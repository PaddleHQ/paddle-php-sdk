<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\CustomerPortalSession;

use Paddle\SDK\Notifications\Entities\Entity;

class CustomerPortalSessionUrls implements Entity
{
    /**
     * @param CustomerPortalSessionSubscriptionUrl[] $subscriptions
     */
    private function __construct(
        public CustomerPortalSessionGeneralUrl $general,
        public array $subscriptions,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            general: CustomerPortalSessionGeneralUrl::from($data['general']),
            subscriptions: array_map(
                fn (array $item): CustomerPortalSessionSubscriptionUrl => CustomerPortalSessionSubscriptionUrl::from($item),
                $data['subscriptions'] ?? [],
            ),
        );
    }
}
