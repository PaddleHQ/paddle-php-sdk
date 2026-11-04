<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Simulation;

use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Notifications\Entities\Shared\PriceTrialPeriod;
use Paddle\SDK\Notifications\Entities\Simulation\Price;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    use ReadsFixtures;

    /**
     * @test
     */
    public function it_supports_paid_trial_period(): void
    {
        $data = self::readJsonFixture('notification/entity/price.updated');
        $price = Price::from($data);

        self::assertInstanceOf(PriceTrialPeriod::class, $price->trialPeriod);
        self::assertTrue($price->trialPeriod->requiresPaymentMethod);
        self::assertSame('100', $price->trialPeriod->unitPrice?->amount);
        self::assertCount(1, $price->trialPeriod->unitPriceOverrides);

        $payload = json_decode(JsonEncoder::default()->encode($price), true);
        self::assertEquals($data['trial_period'], $payload['trial_period']);
    }

    /**
     * @test
     */
    public function it_defaults_paid_trial_fields_when_missing(): void
    {
        $price = Price::from(self::readJsonFixture('notification/entity/price.created'));

        self::assertInstanceOf(PriceTrialPeriod::class, $price->trialPeriod);
        self::assertTrue($price->trialPeriod->requiresPaymentMethod);
        self::assertNull($price->trialPeriod->unitPrice);
        self::assertSame([], $price->trialPeriod->unitPriceOverrides);
    }
}
