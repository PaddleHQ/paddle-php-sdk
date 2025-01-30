<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Business\BusinessesContacts;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Status;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Business implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    /**
     * @param array<BusinessesContacts> $contacts
     */
    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined $name = new Undefined(),
        public readonly string|Undefined|null $companyNumber = new Undefined(),
        public readonly string|Undefined|null $taxIdentifier = new Undefined(),
        public readonly Status|Undefined $status = new Undefined(),
        public readonly array|Undefined $contacts = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
        public readonly string|Undefined|null $customerId = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            name: self::optional($data, 'name'),
            companyNumber: self::optional($data, 'company_number'),
            taxIdentifier: self::optional($data, 'tax_identifier'),
            status: self::optional($data, 'status', fn ($value) => Status::from($value)),
            contacts: self::optionalList($data, 'contacts', fn ($value) => BusinessesContacts::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
            customerId: self::optional($data, 'customer_id'),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'name' => $this->name,
            'company_number' => $this->companyNumber,
            'tax_identifier' => $this->taxIdentifier,
            'status' => $this->status,
            'contacts' => $this->contacts,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'custom_data' => $this->customData,
            'import_meta' => $this->importMeta,
            'customer_id' => $this->customerId,
        ]);
    }
}
