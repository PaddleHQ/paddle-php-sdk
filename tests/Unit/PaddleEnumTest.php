<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit;

use Paddle\SDK\PaddleEnum;
use PHPUnit\Framework\TestCase;

/**
 * MyCLabs caches enum instances per class for the whole run, so tests that depend on
 * what has been hydrated before use their own enum class.
 */
class PaddleEnumTest extends TestCase
{
    /** @test */
    public function it_hydrates_known_values(): void
    {
        $enum = KnownValuesEnum::from('active');

        self::assertTrue($enum->isKnown());
        self::assertSame('active', $enum->getValue());
        self::assertSame('Active', $enum->getKey());
        self::assertTrue($enum->equals(KnownValuesEnum::Active()));
        self::assertTrue(KnownValuesEnum::from('active')->equals($enum));
    }

    /** @test */
    public function it_hydrates_unknown_values_as_undefined_with_the_raw_value(): void
    {
        $enum = UnknownValueEnum::from('new_value');

        self::assertFalse($enum->isKnown());
        self::assertSame('new_value', $enum->getValue());
        self::assertSame('Undefined', $enum->getKey());
        self::assertInstanceOf(UnknownValueEnum::class, $enum);
    }

    /** @test */
    public function it_keeps_each_unknown_value_separate(): void
    {
        $first = SeparateValuesEnum::from('first_new_value');
        $second = SeparateValuesEnum::from('second_new_value');
        $firstAgain = SeparateValuesEnum::from('first_new_value');

        self::assertNotSame($first, $second);
        self::assertSame('first_new_value', $first->getValue());
        self::assertSame('second_new_value', $second->getValue());
        self::assertSame('first_new_value', $firstAgain->getValue());
        self::assertTrue($first->equals($firstAgain));
        self::assertFalse($first->equals($second));
    }

    /** @test */
    public function it_does_not_change_undefined_when_the_first_value_hydrated_is_unknown(): void
    {
        FirstUnknownEnum::from('first_new_value');
        FirstUnknownEnum::from('second_new_value');

        self::assertNull(FirstUnknownEnum::Undefined()->getValue());
        self::assertSame('Undefined', FirstUnknownEnum::Undefined()->getKey());
        self::assertFalse(FirstUnknownEnum::Undefined()->equals(FirstUnknownEnum::from('first_new_value')));
    }

    /** @test */
    public function it_does_not_change_undefined_when_undefined_was_used_first(): void
    {
        $undefined = UndefinedFirstEnum::Undefined();
        UndefinedFirstEnum::from('new_value');

        self::assertNull($undefined->getValue());
        self::assertNull(UndefinedFirstEnum::Undefined()->getValue());
    }

    /** @test */
    public function it_does_not_change_known_values_after_hydrating_unknown_values(): void
    {
        KnownAfterUnknownEnum::from('new_value');

        self::assertSame('active', KnownAfterUnknownEnum::Active()->getValue());
        self::assertSame('active', KnownAfterUnknownEnum::from('active')->getValue());
        self::assertTrue(KnownAfterUnknownEnum::from('active')->isKnown());
    }

    /** @test */
    public function it_keeps_unknown_values_of_one_enum_out_of_another(): void
    {
        IsolatedEnumA::from('new_value');

        self::assertNull(IsolatedEnumB::Undefined()->getValue());
        self::assertSame('other_value', IsolatedEnumB::from('other_value')->getValue());
    }

    /** @test */
    public function it_hydrates_null_as_undefined(): void
    {
        $enum = NullValueEnum::from(null);

        self::assertFalse($enum->isKnown());
        self::assertNull($enum->getValue());
    }

    /** @test */
    public function it_hydrates_null_as_undefined_after_unknown_values(): void
    {
        NullAfterUnknownEnum::from('new_value');

        self::assertNull(NullAfterUnknownEnum::from(null)->getValue());
    }

    /** @test */
    public function it_serializes_unknown_values(): void
    {
        $enum = SerializedEnum::from('new_value');

        self::assertSame('"new_value"', json_encode($enum));
        self::assertSame('new_value', (string) $enum);

        $unserialized = unserialize(serialize($enum));
        self::assertSame('new_value', $unserialized->getValue());
        self::assertFalse($unserialized->isKnown());
    }
}

final class KnownValuesEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class UnknownValueEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class SeparateValuesEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class FirstUnknownEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class UndefinedFirstEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class KnownAfterUnknownEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class IsolatedEnumA extends PaddleEnum
{
    private const Active = 'active';
}

final class IsolatedEnumB extends PaddleEnum
{
    private const Active = 'active';
}

final class NullValueEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class NullAfterUnknownEnum extends PaddleEnum
{
    private const Active = 'active';
}

final class SerializedEnum extends PaddleEnum
{
    private const Active = 'active';
}
