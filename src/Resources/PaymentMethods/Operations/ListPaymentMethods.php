<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\PaymentMethods\Operations;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListPaymentMethods implements HasParameters
{
    /**
     * @param array<string> $addressIds
     *
     * @throws InvalidArgumentException If addressIds contain the incorrect type
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $addressIds = [],
        private readonly bool|null $supportsCheckout = null,
    ) {
        if ($invalid = array_filter($this->addressIds, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('address_ids', 'string', implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'address_id' => implode(',', $this->addressIds),
                'supports_checkout' => isset($this->supportsCheckout) ? ($this->supportsCheckout ? 'true' : 'false') : null,
            ]),
        );
    }
}
