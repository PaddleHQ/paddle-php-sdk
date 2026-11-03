<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

class AccountDetails implements Entity
{
    private function __construct(
        public string $id,
        public string|null $legacyId,
        public string|null $legalName,
        public string|null $displayName,
        public string|null $website,
        public string|null $email,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            legacyId: $data['legacy_id'] ?? null,
            legalName: $data['legal_name'] ?? null,
            displayName: $data['display_name'] ?? null,
            website: $data['website'] ?? null,
            email: $data['email'] ?? null,
        );
    }
}
