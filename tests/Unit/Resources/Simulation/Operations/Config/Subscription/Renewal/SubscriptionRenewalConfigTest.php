<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Simulation\Operations\Config\Subscription\Renewal;

use Paddle\SDK\Entities\Simulation\Config\Option\PaymentOutcome;
use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalConfig;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalEntities;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalOptions;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;

class SubscriptionRenewalConfigTest extends TestCase
{
    /** @test */
    public function it_serializes_full_config_correctly(): void
    {
        $config = new SubscriptionRenewalConfig(
            entities: new SubscriptionRenewalEntities(
                subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
            ),
            options: new SubscriptionRenewalOptions(
                paymentOutcome: PaymentOutcome::RecoveredUpdatedPaymentMethod(),
                dunningExhaustedAction: null,
            ),
        );

        $serializedData = JsonEncoder::default()->encode($config);

        $expected = json_encode([
            'subscription_renewal' => [
                'entities' => [
                    'subscription_id' => 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ],
                'options' => [
                    'payment_outcome' => 'recovered_updated_payment_method',
                    'dunning_exhausted_action' => null,
                ],
            ],
        ]);

        self::assertJsonStringEqualsJsonString($expected, $serializedData);
    }

    /** @test */
    public function it_serializes_minimal_config_correctly(): void
    {
        $config = new SubscriptionRenewalConfig(
            entities: new SubscriptionRenewalEntities(
                subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
            ),
            options: new SubscriptionRenewalOptions(),
        );

        $serializedData = JsonEncoder::default()->encode($config);

        $expected = json_encode([
            'subscription_renewal' => [
                'entities' => [
                    'subscription_id' => 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ],
                'options' => (object) [],
            ],
        ]);

        self::assertJsonStringEqualsJsonString($expected, $serializedData);
    }

    /** @test */
    public function it_filters_undefined_values(): void
    {
        $config = new SubscriptionRenewalConfig(
            entities: new SubscriptionRenewalEntities(
                subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
            ),
            options: new Undefined(),
        );

        $serializedData = json_decode(JsonEncoder::default()->encode($config), true);

        self::assertArrayHasKey('entities', $serializedData['subscription_renewal']);
        self::assertArrayNotHasKey('options', $serializedData['subscription_renewal']);
        self::assertEquals('sub_01h04vsc0qhwtsbsxh3422wjs4', $serializedData['subscription_renewal']['entities']['subscription_id']);
    }
}
