<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

class NotificationLog implements Entity
{
    private function __construct(
        public string $id,
        public int $responseCode,
        public string|null $responseContentType,
        public string $responseBody,
        public \DateTimeInterface $attempted_at,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['response_code'],
            $data['response_content_type'] ?? null,
            $data['response_body'],
            DateTime::from($data['attempted_at']),
        );
    }
}
