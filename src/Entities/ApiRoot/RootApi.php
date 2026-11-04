<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\ApiRoot;

class RootApi
{
    private function __construct(
        public string $name,
        public string $version,
        public RootEnvironment $environment,
        public string $documentationUrl,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            version: $data['version'],
            environment: RootEnvironment::from($data['environment']),
            documentationUrl: $data['documentation_url'],
        );
    }
}
