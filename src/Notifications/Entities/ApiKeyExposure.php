<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\ApiKeyExposure\ApiKeyExposureActionTaken;
use Paddle\SDK\Notifications\Entities\ApiKeyExposure\ApiKeyExposureRiskLevel;
use Paddle\SDK\Notifications\Entities\ApiKeyExposure\ApiKeyExposureSource;

class ApiKeyExposure implements Entity
{
    private function __construct(
        public string $id,
        public string $apiKeyId,
        public ApiKeyExposureRiskLevel $riskLevel,
        public ApiKeyExposureActionTaken $actionTaken,
        public ApiKeyExposureSource $source,
        public string $reference,
        public string|null $description,
        public \DateTimeInterface $createdAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            apiKeyId: $data['api_key_id'],
            riskLevel: ApiKeyExposureRiskLevel::from($data['risk_level']),
            actionTaken: ApiKeyExposureActionTaken::from($data['action_taken']),
            source: ApiKeyExposureSource::from($data['source']),
            reference: $data['reference'],
            description: $data['description'] ?? null,
            createdAt: DateTime::from($data['created_at']),
        );
    }
}
