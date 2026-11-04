<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\Resources\Settings\Operations\Update\CurrencyConversionUpdate;

class UpdateCurrencyConversions implements \JsonSerializable
{
    /**
     * @param array<string, CurrencyConversionUpdate> $conversions keyed by three-letter ISO 4217 currency code
     */
    public function __construct(
        public readonly array $conversions,
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->conversions;
    }
}
