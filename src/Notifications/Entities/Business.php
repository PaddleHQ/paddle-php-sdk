<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Business\BusinessesContacts;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Shared\Status;

class Business implements Entity
{
    /**
     * @param array<BusinessesContacts> $contacts
     */
    private function __construct(
        public string $id,
        public string $name,
        public string|null $companyNumber,
        public string|null $taxIdentifier,
        public Status $status,
        public array $contacts,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public CustomData|null $customData,
        public ImportMeta|null $importMeta,
        public string|null $customerId,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            companyNumber: $data['company_number'] ?? null,
            taxIdentifier: $data['tax_identifier'] ?? null,
            status: Status::from($data['status']),
            contacts: array_map(fn (array $contact): BusinessesContacts => BusinessesContacts::from($contact), $data['contacts']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
            customerId: $data['customer_id'] ?? null,
        );
    }
}
