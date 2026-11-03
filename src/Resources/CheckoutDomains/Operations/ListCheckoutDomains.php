<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\CheckoutDomains\Operations;

use Paddle\SDK\Entities\CheckoutDomain\CheckoutDomainApprovalStatus;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListCheckoutDomains implements HasParameters
{
    /**
     * @param array<string>                       $ids
     * @param array<CheckoutDomainApprovalStatus> $statuses
     *
     * @throws InvalidArgumentException On invalid array contents
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $ids = [],
        private readonly string|null $domain = null,
        private readonly array $statuses = [],
    ) {
        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof CheckoutDomainApprovalStatus)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', CheckoutDomainApprovalStatus::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn (CheckoutDomainApprovalStatus $enum): string => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'id' => implode(',', $this->ids),
                'domain' => $this->domain,
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
            ]),
        );
    }
}
