<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\ImportMeta;
use Paddle\SDK\Entities\Shared\Status;

class Address implements Entity
{
    private function __construct(
        public string $id,
        public string $customerId,
        public string|null $description,
        public string|null $firstLine,
        public string|null $secondLine,
        public string|null $city,
        public string|null $postalCode,
        public string|null $region,
        public CountryCode $countryCode,
        public CustomData|null $customData,
        public Status $status,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public ImportMeta|null $importMeta,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            customerId: $data['customer_id'],
            description: $data['description'] ?? null,
            firstLine: $data['first_line'] ?? null,
            secondLine: $data['second_line'] ?? null,
            city: $data['city'] ?? null,
            postalCode: $data['postal_code'] ?? null,
            region: $data['region'] ?? null,
            countryCode: CountryCode::from($data['country_code']),
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            status: Status::from($data['status']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
        );
    }
}
