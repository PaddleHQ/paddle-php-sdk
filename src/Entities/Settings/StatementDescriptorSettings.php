<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\Entities\Entity;

class StatementDescriptorSettings implements Entity
{
    private function __construct(
        public string $name,
        public StatementDescriptorPreview $preview,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            preview: StatementDescriptorPreview::from($data['preview']),
        );
    }
}
