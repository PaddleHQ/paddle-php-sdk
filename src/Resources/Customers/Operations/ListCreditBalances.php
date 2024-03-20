<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Customers\Operations;

use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;

class ListCreditBalances implements HasParameters
{
    /**
     * @param array<CurrencyCode> $currencyCodes
     *
     * @throws InvalidArgumentException On invalid array contents
     */
    public function __construct(
        private readonly array $currencyCodes = [],
    ) {
        if ($invalid = array_filter($this->currencyCodes, fn ($value): bool => ! $value instanceof CurrencyCode)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('currencyCodes', CurrencyCode::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_filter([
            'currency_code' => implode(',', array_map($enumStringify, $this->currencyCodes)),
        ]);
    }
}
