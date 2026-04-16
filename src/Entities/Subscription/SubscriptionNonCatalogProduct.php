<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\TaxCategory;

class SubscriptionNonCatalogProduct implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public string|null $description,
        /** @deprecated Not accepted by the API. Ignored during serialization. Will be removed in a future version. */
        public CatalogType|null $type,
        public TaxCategory $taxCategory,
        public string|null $imageUrl,
        public CustomData|null $customData,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'tax_category' => $this->taxCategory,
            'image_url' => $this->imageUrl,
            'custom_data' => $this->customData,
        ];
    }
}
