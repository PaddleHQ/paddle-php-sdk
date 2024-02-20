<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities;

class DateTime extends \DateTimeImmutable
{
    final public const PADDLE_RFC3339 = 'Y-m-d\TH:i:s.up';

    private function __construct(string $datetime = 'now')
    {
        // Ensure formatted dates are in UTC
        parent::__construct(datetime: $datetime, timezone: new \DateTimeZone('UTC'));
    }

    public function format(string|null $format = null): string
    {
        return parent::format($format ?? self::PADDLE_RFC3339);
    }

    public static function from(string|\DateTimeInterface $date): self|null
    {
        if ($date === '0001-01-01T00:00:00Z') {
            return null;
        }

        $date = is_string($date) ? $date : $date->format(self::PADDLE_RFC3339);

        try {
            return new self($date);
        } catch (\Exception) {
            return null;
        }
    }
}
