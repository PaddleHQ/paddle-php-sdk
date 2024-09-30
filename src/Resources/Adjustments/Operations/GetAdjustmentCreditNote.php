<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Adjustments\Operations;

use Paddle\SDK\Entities\Shared\Disposition;
use Paddle\SDK\HasParameters;

class GetAdjustmentCreditNote implements HasParameters
{
    public function __construct(
        private readonly Disposition|null $disposition = null,
    ) {
    }

    public function getParameters(): array
    {
        return array_filter([
            'disposition' => $this->disposition?->getValue(),
        ]);
    }
}
