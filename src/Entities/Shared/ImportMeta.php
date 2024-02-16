<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class ImportMeta
{
    private function __construct(
        public readonly string|null $externalId,
        public readonly string $importedFrom,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            externalId: $data['external_id'] ?? null,
            importedFrom: $data['imported_from'],
        );
    }
}
