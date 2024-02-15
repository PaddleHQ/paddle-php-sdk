<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Products\Operations;

use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Products\Operations\List\Includes;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListProducts implements HasParameters
{
    /**
     * @param Includes[]    $includes
     * @param string[]      $ids
     * @param CatalogType[] $types
     * @param Status[]      $statuses
     * @param TaxCategory[] $taxCategories
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        private readonly Pager|null $pager = null,
        private readonly array $includes = [],
        private readonly array $ids = [],
        private readonly array $types = [],
        private readonly array $statuses = [],
        private readonly array $taxCategories = [],
    ) {
        if ($invalid = array_filter($this->includes, fn ($value): bool => ! $value instanceof Includes)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('includes', Includes::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->ids, fn ($value): bool => ! is_string($value))) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('ids', 'string', implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->types, fn ($value): bool => ! $value instanceof CatalogType)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('types', CatalogType::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->statuses, fn ($value): bool => ! $value instanceof Status)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('statuses', Status::class, implode(', ', $invalid));
        }

        if ($invalid = array_filter($this->taxCategories, fn ($value): bool => ! $value instanceof TaxCategory)) {
            throw InvalidArgumentException::arrayContainsInvalidTypes('taxCategories', Status::class, implode(', ', $invalid));
        }
    }

    public function getParameters(): array
    {
        $enumStringify = fn ($enum) => $enum->getValue();

        return array_merge(
            $this->pager?->getParameters() ?? [],
            array_filter([
                'include' => implode(',', array_map($enumStringify, $this->includes)),
                'id' => implode(',', $this->ids),
                'type' => implode(',', array_map($enumStringify, $this->types)),
                'status' => implode(',', array_map($enumStringify, $this->statuses)),
                'tax_category' => implode(',', array_map($enumStringify, $this->taxCategories)),
            ]),
        );
    }
}
