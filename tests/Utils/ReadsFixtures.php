<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Utils;

trait ReadsFixtures
{
    public static function readJsonFixture(string $fixture): array
    {
        [$caller] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $basePath = dirname($caller['file']);

        return json_decode(self::readRawJsonFixture($fixture, $basePath), true, 512, JSON_THROW_ON_ERROR);
    }

    public static function readRawJsonFixture(string $fixture, string|null $basePath = null): string
    {
        if (! $basePath) {
            [$caller] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
            $basePath = dirname($caller['file']);
        }

        while ($basePath !== dirname(__DIR__)) {
            $file = "{$basePath}/_fixtures/{$fixture}.json";

            if (! file_exists($file)) {
                $basePath = dirname($basePath);
                continue;
            }

            return trim(file_get_contents($file));
        }

        throw new \InvalidArgumentException("Fixture '{$fixture}' not found!");
    }
}
