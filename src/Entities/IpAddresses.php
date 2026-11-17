<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

class IpAddresses implements Entity
{
    /**
     * @param array<string> $ipv4Cidrs
     */
    private function __construct(
        public array $ipv4Cidrs,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            ipv4Cidrs: $data['ipv4_cidrs'] ?? [],
        );
    }
}
