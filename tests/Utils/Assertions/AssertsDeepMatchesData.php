<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Utils\Assertions;

use PHPUnit\Framework\Assert;

trait AssertsDeepMatchesData
{
    public static function assertDeepMatchesData(object $object, array $data): void
    {
        foreach ($data as $prop => $value) {
            // snake case -> camel case
            $prop = preg_replace_callback('/_(.?)/', fn (array $matches) => strtoupper($matches[1]), $prop);

            Assert::assertArrayHasKey($prop, get_object_vars($object), "{$prop} is missing from object");

            self::assertMatch($value, $object->{$prop});
        }
    }

    private static function assertMatch(mixed $expected, mixed $value): void
    {
        switch (true) {
            case is_object($value) && is_array($expected):
                self::assertDeepMatchesData($value, $expected);
                break;
            case is_object($value) && enum_exists($value::class):
                self::assertEnumMatch($value, $expected);
                break;
            case is_array($value) && is_array($expected):
                foreach ($value as $key => $item) {
                    Assert::assertArrayHasKey($key, $expected, "{$key} is missing from array");
                    self::assertMatch($expected[$key], $item);
                }
                break;
            default:
                Assert::assertEquals($expected, $value);
        }
    }

    private static function assertEnumMatch(object $enum, mixed $value): void
    {
        Assert::assertEquals(
            $value,
            $enum->value,
            sprintf('Enum value "%s" does not match expected value "%s"', $enum->value, $value),
        );
    }
}
