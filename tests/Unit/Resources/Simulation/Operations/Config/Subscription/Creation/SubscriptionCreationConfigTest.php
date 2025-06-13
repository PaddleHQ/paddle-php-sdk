<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Simulation\Operations\Config\Subscription\Creation;

use Paddle\SDK\Entities\Simulation\Config\Option\CustomerSimulatedAs;
use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationConfig;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationEntities;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationItem;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationOptions;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;

class SubscriptionCreationConfigTest extends TestCase
{
    /** @test */
    public function it_serializes_full_config_correctly(): void
    {
        $config = new SubscriptionCreationConfig(
            entities: new SubscriptionCreationEntities(
                customerId: 'ctm_01grnn4zta5a1mf02jjze7y2ys',
                addressId: 'add_01gm302t81w94gyjpjpqypkzkf',
                businessId: 'biz_01grrebrzaee2qj2fqqhmcyzaj',
                paymentMethodId: 'paymtd_01hkm9xwqpbbpr1ksmvg3sx3v1',
                discountId: 'dsc_01gv5kpg05xp104ek2fmgjwttf',
                items: [
                    new SubscriptionCreationItem('pri_01gsz8z1q1n00f12qt82y31smh', 5),
                    new SubscriptionCreationItem('pri_01gsz8z1q1n00f12qt82y31smi', 2),
                ],
            ),
            options: new SubscriptionCreationOptions(
                customerSimulatedAs: CustomerSimulatedAs::ExistingEmailMatched(),
            ),
        );

        $serializedData = JsonEncoder::default()->encode($config);

        $expected = json_encode([
            'subscription_creation' => [
                'entities' => [
                    'customer_id' => 'ctm_01grnn4zta5a1mf02jjze7y2ys',
                    'address_id' => 'add_01gm302t81w94gyjpjpqypkzkf',
                    'business_id' => 'biz_01grrebrzaee2qj2fqqhmcyzaj',
                    'payment_method_id' => 'paymtd_01hkm9xwqpbbpr1ksmvg3sx3v1',
                    'discount_id' => 'dsc_01gv5kpg05xp104ek2fmgjwttf',
                    'items' => [
                        [
                            'price_id' => 'pri_01gsz8z1q1n00f12qt82y31smh',
                            'quantity' => 5,
                        ],
                        [
                            'price_id' => 'pri_01gsz8z1q1n00f12qt82y31smi',
                            'quantity' => 2,
                        ],
                    ],
                ],
                'options' => [
                    'customer_simulated_as' => 'existing_email_matched',
                ],
            ],
        ]);

        self::assertJsonStringEqualsJsonString($expected, $serializedData);
    }

    /** @test */
    public function it_serializes_minimal_config_correctly(): void
    {
        $config = new SubscriptionCreationConfig(
            entities: new SubscriptionCreationEntities(
                customerId: 'ctm_01grnn4zta5a1mf02jjze7y2ys',
                items: [
                    new SubscriptionCreationItem('pri_01gsz8z1q1n00f12qt82y31smh', 1),
                ],
            ),
        );

        $serializedData = JsonEncoder::default()->encode($config);

        $expected = json_encode([
            'subscription_creation' => [
                'entities' => [
                    'customer_id' => 'ctm_01grnn4zta5a1mf02jjze7y2ys',
                    'items' => [
                        [
                            'price_id' => 'pri_01gsz8z1q1n00f12qt82y31smh',
                            'quantity' => 1,
                        ],
                    ],
                ],
            ],
        ]);

        self::assertJsonStringEqualsJsonString($expected, $serializedData);
    }

    /** @test */
    public function it_filters_undefined_values(): void
    {
        $config = new SubscriptionCreationConfig(
            entities: new SubscriptionCreationEntities(
                customerId: 'ctm_01grnn4zta5a1mf02jjze7y2ys',
                addressId: new Undefined(),
                businessId: new Undefined(),
                paymentMethodId: new Undefined(),
                discountId: new Undefined(),
                items: new Undefined(),
            ),
            options: new Undefined(),
        );

        $serializedData = JsonEncoder::default()->encode($config);

        $expected = json_encode([
            'subscription_creation' => [
                'entities' => [
                    'customer_id' => 'ctm_01grnn4zta5a1mf02jjze7y2ys',
                ],
            ],
        ]);

        self::assertJsonStringEqualsJsonString($expected, $serializedData);
    }
}
