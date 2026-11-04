<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\ApiRoot;

class RootCaller
{
    /**
     * @param array<string> $permissions
     */
    private function __construct(
        public RootAuthType|null $authType,
        public RootCallerAccount|null $account,
        public array $permissions,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            authType: isset($data['auth_type']) ? RootAuthType::from($data['auth_type']) : null,
            account: isset($data['account']) ? RootCallerAccount::from($data['account']) : null,
            permissions: $data['permissions'] ?? [],
        );
    }
}
